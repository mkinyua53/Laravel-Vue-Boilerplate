<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\User;
use Auth;

class InstallController extends Controller
{
    /* *
    * Initialise permissions
     */
    public function permissions()
    {
        $permissions = [
            // [
            //     'name' => '',
            //     'label' => '',
            // ],
        ];

        foreach ($permissions as $key) {
            Permission::firstOrCreate(['name' => $key['name']], $key);
            Permission::updateOrCreate(['name' => $key['name']], ['label' => $key['label']]);
        }

        return $this;
    }

    /**
     * Initialise roles
     */
    public function roles()
    {
        $roles = [
            [
                'name'  => 'Developer',
                'label' => 'Holds all permissions and intended for developers and support team members'
            ],
            [
                'name'  => 'SuperAdmin',
                'label' => 'Holds all permissions'
            ],
            [
                'name' => 'UserManager',
                'label' => 'Authorization to grant and revoke users access'
            ],
            [
                'name' => 'Admin',
                'label' => 'Holds all permissions'
            ]
        ];

        foreach ($roles as $key) {
            Role::firstOrCreate(['name' => $key['name']], $key);
            Role::updateOrCreate(['name' => $key['name']], ['label' => $key['label']]);
        }

        return $this;
    }

    /**
     * Initialise the main roles
     */
    public function initRoles()
    {
        $developer = Role::where('name', 'Developer')->first();
        $superadmin = Role::where('name', 'SuperAdmin')->first();
        $admin = Role::where('name', 'Admin')->first();

        $allPermissions = Permission::all();

        $developer->permissions()->syncWithoutDetaching($allPermissions);
        $superadmin->permissions()->syncWithoutDetaching($allPermissions);
        $admin->permissions()->syncWithoutDetaching($allPermissions);

        return $this;
    }

    /**
     * Install Authorization
     */
    public function installAuth()
    {
        try {
            $this->permissions()->roles()->initRoles();
        } catch (\Exception $e) {
            return $e;
        }

        return 'All Done';
    }

    /**
     * Reset Auth
     */
    public function resetAuth()
    {
        if (!Auth::user()->hasAnyRoles(['Developer', 'SuperAdmin'])) {
            return (new \Illuminate\Http\Response)->setStatusCode(403, 'Not Allowed');
        }
        $user = Auth::user();

        \DB::table('role_user')->truncate();
        \DB::table('permission_user')->truncate();
        \DB::table('permission_role')->truncate();
        \DB::table('roles')->delete();
        \DB::table('permissions')->delete();

        $done = $this->installAuth();
        $roles = Role::where('name', 'SuperAdmin')
            ->orWhere('name', 'UserManager')
            ->get();

        $user->roles()->attach($roles);

        return $done;
    }
}
