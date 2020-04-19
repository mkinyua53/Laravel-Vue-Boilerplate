<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Permission;
use Session;
use Auth;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user() && ! Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        $permissions = Permission::with('roles','users')->orderBy('name')->get();

        return $permissions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->action('RoleController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Auth::user()->hasRole('Developer')) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
            'label'=> 'required'
            ]);

        $permission = new Permission;
        $permission->fill($request->all());
        $permission->save();

        if ($permission) {
            return back()->withMessage('Permission Saved');
        }
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user() && ! Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        $permission = Permission::with('users','roles')->find($id);

        if(! $permission){
            return response()->json('',404);
        }

        return $permission;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Auth::user()->hasRole('Developer')) {
            abort(403);
        }

        $permission = Permission::findOrFail($id);

        return view('permissions.edit')
            ->withMessage('Changing the permission name will render it useless')
            ->withPermission($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Auth::user()->hasRole('Developer')) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
            'label'=> 'required'
            ]);

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        if ($permission) {
            Session::flash('message','Permission Updated. Some functionalities of this app might be lost as a result. Contact Developer.');
            return redirect()->action('PermissionController@index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Auth::user()->hasRole('Developer')) {
            abort(403);
        }

        $permission = Permission::findOrFail($id);

        if ($permission->delete()) {
            Session::flash('message','Permission Deleted. Any resource dependant on this permission wont work');
            return redirect()->action('PermissionController@index');
        }
        return redirect()->action('PermissionController@index');
    }

    /**
    *
    * Assign permission to user
    *
    * @param int $permissionId, $userId
    * @return Illuminate\Http\Response
    **/
    public function attachUser($permissionId, $userId)
    {
        // if (! Auth::user()->hasAnyRoles(['Developer','Headteacher','Superadmin'])) {
        //     abort(403);
        // }

        //check the permission exist
        $permission = Permission::find($permissionId);
        //get the user
        $user = \App\User::find($userId);

        if(! $permission || ! $user){
            if(\Request::ajax()){
                return response()->json('',404);
            }
            abort(404);
        }
        $permission->users()->syncWithoutDetaching([$user->id]);

        if(\Request::ajax()){
            return response()->json('',200);
        }
        return back()->withMessage('Permission granted to user');
    }

    /**
    *
    * Detach permission from user
    *
    * @param int $permissionId, $userId
    * @return Illuminate\Http\Response
    **/
    public function detachUser($permissionId, $userId)
    {
        // if (! Auth::user()->hasAnyRoles(['Developer','Headteacher','Superadmin'])) {
        //     abort(403);
        // }

        $permission = Permission::find($permissionId);
        $user = \App\User::find($userId);

        if(! $permission || ! $user){
            if(\Request::ajax()){
                return response()->json('',404);
            }
            abort(404);
        }
        $user->permissions()->detach($permissionId);

        if(\Request::ajax()){
            return response()->json('',200);
        }
        return back()->withMessage('User detached of the permission');
    }

    /**
    *
    * Detach all permission from user
    *
    * @param int $user
    * @return Illuminate\Http\Response
    **/
    public function detachUserAll($id)
    {
        if (! \Auth::user()->hasAnyRoles(['Developer','Headteacher','Superadmin'])) {
            abort(403);
        }

        $user = \App\User::find($id);

        if(! $user){
            if(\Request::ajax()){
                return response()->json('',404);
            }
            abort(404);
        }

        if ($user->id == \Auth::user()->id) {
            if(\Request::ajax()){
                return response()->json('',422);
            }
            return back()->withMessage('Not allowed');
        }
        $user->permissions()->detach();

        if(\Request::ajax()){
            return response()->json('',200);
        }
        return redirect()->action('PermissionController@index')->withMessage('User Stripped of all permissions');
    }
}
