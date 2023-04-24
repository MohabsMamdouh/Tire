<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AccessController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:super_admin|assign permission|assign role']);
    }


    public function showRoles()
    {
        $roles = Role::where('name', '<>', 'super_admin')->get();

        $data = [
            'roles' => $roles,
            'title' => 'Roles'
        ];

        return view('access.show-roles', $data);
    }


    public function createRole()
    {
        $data = [
            'title' => 'Create New Role'
        ];

        return view('access.create-role', $data);
    }

    public function storeRole(Request $request)
    {
        $role = Role::create(['name' => $request['role_name']]);

        return redirect(route('access.assignPermissionToRole', ['id' => $role->id]));
    }

    public function assignPermissionToRole($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'title' => 'Assign Permissions To Role'
        ];

        return view('access.form-roles', $data);
    }

    public function storePermissionToRole(Request $request, $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        foreach ($permissions as $per) {
            if (isset($request[str_replace(' ', '-', $per->name) . '-' . $per->id])) {
                $role->givePermissionTo($per->name);
            } else {
                $role->revokePermissionTo($per->name);
            }
        }

        return redirect()->back();
    }

    public function PermissionAssignToUser($id)
    {
        $user = User::with('permissions', 'roles')->find($id);
        $permissions = Permission::all();

        $data = [
            'user' => $user,
            'permissions' => $permissions,
            'title' => 'Assign Permissions To User'
        ];

        return view('access.user-permission', $data);
    }

    public function StorePermissionAssignToUser(Request $request, $id)
    {
        $user = User::find($id);
        $permissions = Permission::all();

        foreach ($permissions as $per) {
            if (isset($request[str_replace(' ', '-', $per->name) . '-' . $per->id])) {
                $user->givePermissionTo($per->name);
            } else {
                $user->revokePermissionTo($per->name);
            }
        }

        return redirect()->back();
    }

    public function destroyRole($id)
    {
        $role = Role::where('id', $id)->delete();

        return redirect(route('access.showRoles'));
    }

    public function makeSuperAdmin()
    {
        $users = User::where('id', '<>', Auth::user()->id)
                    ->whereHas('roles', function($query){
                        $query->where('name', '<>', 'super_admin'); // role with no super_admin
                    })->get();

        $superAdmins = User::where('id', '<>', Auth::user()->id)
                            ->whereHas('roles', function($query)
                            {
                                $query->where('name', 'super_admin'); // role with super_admin
                            })->get();

        $data = [
            'users' => $users,
            'superAdmins' => $superAdmins,
            'title' => 'Create Super Admin'
        ];

        return view('access.makeSuperAdmin', $data);
    }

    public function storeSuperAdmin(Request $request)
    {
        $user = User::find($request['users']);

        foreach ($user->roles as $role) {
            $user->removeRole($role->name);
        }

        $user->assignRole('super_admin');

        return redirect(route('user.ShowSingle', ['id' => $user->id]));

    }

    public function deleteSuperAdmin(Request $request)
    {
        $user = User::find($request['users']);

        foreach ($user->roles as $role) {
            $user->removeRole($role->name);
        }

        $user->assignRole('mechanic');

        return redirect(route('user.ShowSingle', ['id' => $user->id]));

    }
}
