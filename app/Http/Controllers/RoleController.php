<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Role;
use Session;
use Auth;

class RoleController extends Controller
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

        $roles = Role::with('users','permissions')->orderBy('name')->get();

        return $roles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //the create form is displayed within the index page
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
        // if (! Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
        //     abort(403);
        // }

        $this->validate($request, [
            'name' => 'required',
            'label'=> 'required'
            ]);

        $role = new Role;
        $role->fill($request->all());
        $role->save();

        if ($role) {
            return back()->withMessage('Role saved');
        }
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

        $role = Role::with('users','permissions')->find($id);

        if(! $role){
            return response()->json('',404);
        }

        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Auth::user()->hasAnyAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        Session::flash('message', 'Changing the permission name will render it useless');
        return view('roles.edit')->withRole($role);
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
        if (! Auth::user()->hasRoles(['Developer'])) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
            'label'=> 'required'
            ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        return $role;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Auth::user()->hasRoles(['Developer'])) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        $role->delete();
        if ($role) {
            Session::flash('message', 'Role Deleted');
            return redirect()->action('RoleController@index');
        }
        return back();
    }


    /**
    *
    * Attach role to user
    *
    * @param int $roleId, $userId
    * @return \Illuminata\Http\Response
    */
    public function attachUser($roleId, $userId)
    {
        if (! Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        //check if the role exist first
        $role = Role::find($roleId);
        //find the user
        $user = \App\User::find($userId);

        if(! $role || ! $user){
            return response()->json('',404);
        }

        if ($role->name === 'Developer') {
            return (new \Illuminate\Http\Response)->setStatusCode(429, 'Sorry, you can not attach this role. Preserved for support team only');
        }

        $role->users()->syncWithoutDetaching([$user->id]);

        return response()->json('',200);
    }

    /**
    *
    * Attach a permission to user
    *
    * @param int $roleId, $permissionId
    * @return Illuminate\Http\Response
    */
    public function attachPermission($roleId, $permissionId)
    {
        if (! Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        //check if the role exists
        $role = Role::find($roleId);
        //find the permission
        $permission = \App\Permission::find($permissionId);

        if(! $role || ! $permission){
            return response()->json('',404);
        }

        $permission->roles()->syncWithoutDetaching([$role->id]);

        return response()->json('',200);
    }

    /**
    *
    * Detach a user from a role
    *
    * @param int $roleId, $userId
    * @return Illuminate\Http\Response
    **/
    public function detachUser($roleId, $userId)
    {
        if (! Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        $user = \App\User::find($userId);

        if(! $user){
            return response()->json('',404);
        }

        $user->roles()->detach($roleId);

        return response()->json('',200);
    }

    /**
    *
    * Detach a permission from a role
    *
    * @param int $roleId, $permissionId
    * @return Illuminate\Http\Response
    **/
    public function detachPermission($roleId, $permissionId)
    {
        //Find the permission
        $permission = \App\Permission::find($permissionId);

        if(! $permission){
            return response()->json('',404);
        }

        $permission->roles()->detach($roleId);

        return response()->json('',200);
    }

    /**
    *
    * Detach all roles from a user
    *
    * @param int $id
    * @return Illuminate\Http\Response
    **/
    public function detachUserAll($id)
    {
        if (! \Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        $user = \App\User::find($id);

        if(! $user){
            return response()->json('',404);
        }
        if ($user->id == \Auth::user()->id) {
            return (new \Illuminate\Http\Response)->setStatusCode(425, 'You are trying to detach all roles from your account');
        }

        $user->roles()->detach();

        return response()->json('',200);
    }

    /**
    *
    * Detach all roles from a permission
    *
    * @param int $id
    * @return Illuminate\Http\Response
    **/
    public function detachPermissionAll($id)
    {
        if (! Auth::user()->hasAnyRoles(['Developer','Superadmin','Headteacher'])) {
            abort(403);
        }

        $permission = \App\Permission::find($id);

        if(! $permission){
            return response()->json('',404);
        }

        $permission->roles()->detach();

        return response()->json('',200);
    }
}
