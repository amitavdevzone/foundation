<?php

namespace Inferno\Foundation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inferno\Foundation\Events\Permissions\PermissionDeleted;
use Inferno\Foundation\Events\Roles\RoleDeleted;
use Inferno\Foundation\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminApiController extends Controller
{
	/**
	 * Handling the post request for delete role.
	 */
	public function postDeleteRole(Request $request)
	{
	    $roleId = $request->input('id');
	    // this is only done to get the role name
	    $role = Role::find($roleId);

	    if ($role->name == 'admin' || $role->name == 'auth user') {
            abort(403, 'You cannot edit this role.');
        }

	    DB::table('roles')->where('id', $roleId)->delete();

	    event(new RoleDeleted($role));

	    return response(['data' => 'Role was deleted'], 200);
	}

	/**
	 * Handling the post request for delete permission.
	 */
	public function postDeletePermission(Request $request)
	{
	    $permId = $request->input('id');

	    // this is only done to get the role name
	    $permission = Permission::find($permId);

	    DB::table('permissions')->where('id', $permId)->delete();

	    event(new PermissionDeleted($permission));

	    return response(['data' => 'Permission was deleted.'], 200);
	}
}
