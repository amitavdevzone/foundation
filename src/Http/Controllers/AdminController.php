<?php

namespace Inferno\Foundation\Http\Controllers;

use Inferno\Foundation\Events\Permissions\PermissionCreated;
use Inferno\Foundation\Events\Roles\RoleCreated;
use Inferno\Foundation\Http\Requests\SavePermissionRequest;
use Inferno\Foundation\Http\Requests\SaveRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
	/**
	 * This is the function to return the Manage roles page.
	 */
	public function getManageRoles()
	{
		$roles = Role::orderBy('id', 'asc')->paginate(10);
		return view('inferno-foundation::manage-roles', compact('roles'));
	}

	/**
	 * This function is handling the request to save a new Role.
	 */
	public function postSaveRoles(SaveRoleRequest $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        event(new RoleCreated($role));
        flash('Added a new Role');
        return redirect()->back();
    }

    /**
     * Get the edit role page.
     */
    public function getEditRole($id)
    {
        $role = Role::find($id);
        return view('inferno-foundation::role-edit', compact('role'));
    }

    /**
     * Handle the edit role request.
     */
    public function postUpdateRole(SaveRoleRequest $request)
    {
        $roleId = $request->input('id');
        $role = Role::find($roleId);

        if ($role->name == 'admin' || $role->name == 'auth user') {
            abort(403, 'You cannot edit this role.');
        }

        $role->name = $request->input('name');
        $role->save();

        flash('Role was updated');
        return redirect()->back();
    }

    /**
     * Get the manage permission page.
     */
    public function getManagePermission()
    {
        $permissions = Permission::orderBy('id', 'asc')->paginate(10);
        return view('inferno-foundation::manage-permissions', compact('permissions'));
    }

    /**
     * Handle the save new permission request.
     */
    public function postSavePermission(SavePermissionRequest $request)
    {
        $name = $request->input('name');

        $permission = Permission::create([
            'name' => $name
        ]);

        event(new PermissionCreated($permission));
        flash('New permission was created');
        return redirect()->back();
    }

    /**
     * Handle the edit permission page.
     */
    public function getEditPermission($id)
    {
        $permission = Permission::find($id);

        return view('inferno-foundation::permission-edit', compact('permission'));
    }

    /**
     * Handle the update permission request.
     */
    public function postUpdatePermission(SavePermissionRequest $request)
    {
        $permission = Permission::find($request->input('id'));
        $permission->name = $request->input('name');
        $permission->save();

        flash('Permission was updated');
        return redirect()->back();
    }
}
