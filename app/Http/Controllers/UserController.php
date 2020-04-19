<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Medium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api'])->except(['store', 'login', 'logout']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user() || !Auth::user()->hasAnyRoles(['Developer', 'Superadmin'])) {
            abort(403);
        }

        return User::withCount('roles')->withCount('permissions')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'terms'     => 'required'
        ]);

        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        // $user->accepted_terms = Carbon::now()->toDateTimeString();
        $user->save();

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('permissions', 'roles');

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->id != $user->id) {
            return (new \Illuminate\Http\Response)->setStatusCode(425, 'Not Allowed');
        }
        $user->update($request->all());

        return response()->json('Ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!Auth::user() || !Auth::user()->hasAnyRoles(['Developer', 'Superadmin'])) {
            abort(403);
        }

        if (!$user) {
            return response()->json('', 404);
        }
        if (Auth::user()->email === $user->email) {
            return (new \Illuminate\Http\Response)->setStatusCode(425, 'You are trying to delete your own account.');
        }

        $email = '"' . $user->email . '"';

        $user->update(['email' => $email]);
        $user->delete();

        return response()->json('', 200);
    }

    /**
     * Upload avatar
     *
     * @param int $id \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function avatar(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json('', 404);
        }
        if (\Request::ajax()) {
            $exploded = explode(',', $request->avatar);
            $decoded = base64_decode($exploded[1]);

            if (str_contains($exploded[0], 'jp')) {
                $extension = 'jpg';
            } elseif (str_contains($exploded[0], 'png')) {
                $extension = 'png';
            } elseif (str_contains($exploded[0], 'bmp')) {
                $extension = 'bmp';
            } elseif (str_contains($exploded[0], 'svg')) {
                $extension = 'svg';
            } else {
                return response() - json(['avatar' => 'Unsupported Image type. Use jpg,png,bmp or svg'], 422);
            }
            // dd($extension);
            $time = str_random(4);
            $filename = 'user-' . $user->id . '-' . $time . '.' . $extension;
            \Image::make($decoded)->save(public_path('uploads/avatars/' . $filename));

            $user->avatar = '/uploads/avatars/' . $filename;
            $user->save();
            return response()->json($user->avatar);
        } elseif (!\Request::ajax()) {
            $this->validate($request, [
                'avatar'    => 'required|image|max:2048'
            ]);
            $avatar = $request->file('avatar');
            $filename = 'user-' . $user->id . '-' . str_slug(\Carbon\Carbon::now()) . '.' . $avatar->getClientOriginalExtension();
            \Image::make($avatar)->save(public_path('uploads/avatars/' . $filename));

            $user->avatar = '/uploads/avatars/' . $filename;
            $user->save();

            return back();
        }
    }

    /**
     * Display form to change password
     */
    public function changePassword()
    {
        return view('users.password')->withUser(\Auth::user());
    }

    public function password(Request $request)
    {

        $this->validate($request, [
            'old_password'      => 'required|min:6',
            'password'      => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        $id = $user->id;

        $email = $user->email;
        $password = $request->input('old_password');
        $newpassword = $request->input('password');

        /* Instead of hashing the password and comparing with
        what is in the database, we will just try to login
        with that password.
        If it fails, return to previous page with no inputs. */

        if (!\Request::ajax()) {
            if (!Auth::attempt(['email' => $email, 'password' => $password])) {

                return back()->withErrors(['Password' => 'The password you entered is incorrect.']);
            }
        }

        $user->forceFill([
            'password' => bcrypt($newpassword),
            'remember_token' => null,
        ])->save();

        if (\Request::ajax()) {
            return response()->json('', 200);
        }

        \Auth::loginUsingId($id, true);

        return redirect()->route('profile')->withMessage('Password Changed. Use your new password to login next time.');
    }

    /**
     * Activate/Deactivate a user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function changeActivationStatus(User $user)
    {
        if (!Auth::user() || !Auth::user()->hasAnyRoles(['Developer', 'Superadmin'])) {
            abort(403);
        }

        if (!$user) {
            return response()->json('', 404);
        }

        if ($user->id === \Auth::user()->id) {
            return (new \Illuminate\Http\Response)->setStatusCode(425, 'You can not change your activation status');
        }
        $this->changeStatus($user);

        return response()->json('', 200);
    }

    /**
     * Check the activation status of User
     *
     * @param User $user
     * @return $this
     */

    protected function changeStatus(User $user)
    {
        if ($user->active == "0") {

            $user->active = "1";
            $user->save();
        } else {

            $user->active = "0";
            $user->save();
        }
        return $this;
    }

    public function login(Request $request)
    {
        if (!\Request::ajax()) {
            return redirect('/');
        }
        if (\Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'failed'], 500);
        }
    }

    public function logout()
    {
        if (!\Request::ajax()) {
            return back();
        }
        \Auth::logout();

        return response()->json(['message' => 'success'], 200);
    }

    public function authenticatedUser()
    {
        $user = \Auth::user();
        $user->load('permissions', 'roles');

        return $user;
    }

    public function searchQuery(Request $request)
    {
        $query = $request->query('query');

        $users = User::where('first_name', 'like', "%$query%")
            ->orWhere('middle_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query")
            ->orWhere('email', 'like', "%$query")
            ->orderBy('name', 'asc')
            ->get();

        if (\Request::ajax()) {
            return response()->json($users);
        }

        return back()->withUser($users);
    }

    /**
     * Reset password for a user
     * @param $user
     * @return \Illuminate\Http\Response
     **/
    public function resetPassword(User $user)
    {
        if (!Auth::user() || !Auth::user()->hasAnyRoles(['Developer', 'Superadmin'])) {
            abort(403);
        }

        if (!$user) {
            if (\Request::ajax()) {
                return response()->json('', 404);
            }
            abort(404);
        }

        if ($user->id == \Auth::user()->id) {
            abort(422);
        }

        $user->forceFill([
            'password' => bcrypt($user->email),
            'remember_token' => null,
        ])->save();

        if (\Request::ajax()) {
            return response()->json('', 200);
        }
        return back()->withMessage('Password reset to default.');
    }

    public function acceptCookies(User $user)
    {
        $user->update(['accepted_cookies' => \Carbon\Carbon::now()->toDateTimeString()]);

        return 'Updated';
    }

    public function acceptTerms(User $user)
    {
        $user->update(['accepted_terms' => \Carbon\Carbon::now()->toDateTimeString()]);

        return 'Updated';
    }

    public function changeSubscriber(Request $request, User $user)
    {
        if (!Auth::user() || !Auth::user()->hasRole('Developer')) {
            abort(403);
        }

        if (Auth::user()->id !== $user->id) {
            abort(403);
        }

        $user->update(['subscriber_id' => $request->subscriber_id]);

        return 'Subscriber Changed.';
    }
}
