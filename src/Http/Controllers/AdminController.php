<?php

namespace Inferno\Foundation\Http\Controllers;

use Inferno\Foundation\Http\Requests\SaveRoleRequest;
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
}
