<?php

namespace Inferno\Foundation\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inferno\Foundation\Events\Permissions\PermissionCreated;
use Inferno\Foundation\Events\Roles\RoleCreated;
use Inferno\Foundation\Events\Settings\SettingsCreated;
use Inferno\Foundation\Events\User\UserCreated;
use Inferno\Foundation\Events\User\UserEdited;
use Inferno\Foundation\Http\Requests\SaveNewUserRequest;
use Inferno\Foundation\Http\Requests\SavePermissionRequest;
use Inferno\Foundation\Http\Requests\SaveRoleRequest;
use Inferno\Foundation\Models\Profile;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use anlutro\LaravelSettings\SettingsManager;

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
     *
     * @param SaveRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditRole($id)
    {
        $role = Role::find($id);
        return view('inferno-foundation::role-edit', compact('role'));
    }

    /**
     * Handle the edit role request.
     *
     * @param SaveRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param SavePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditPermission($id)
    {
        $permission = Permission::find($id);

        return view('inferno-foundation::permission-edit', compact('permission'));
    }

    /**
     * Handle the update permission request.
     *
     * @param SavePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdatePermission(SavePermissionRequest $request)
    {
        $permission = Permission::find($request->input('id'));
        $permission->name = $request->input('name');
        $permission->save();

        flash('Permission was updated');
        return redirect()->back();
    }

    /**
     * This function will return the manage users page.
     */
    public function getManageUsers()
    {
        $users = User::orderBy('name', 'asc')->paginate(10);
        $roles = Role::orderBy('name', 'asc')->get();
        return view('inferno-foundation::manage-users', compact('users', 'roles'));
    }

    /**
     * This page will return the edit page user.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditUser($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name', 'asc')->get();
        return view('inferno-foundation::user-edit', compact('user', 'roles'));
    }

    /**
     * Handle the User update request.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'role' => 'required|array',
            'active' => 'required',
        ]);

        if ($validator->fails()) {
            flash('Validations failed.');
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find($request->input('id'));
        $user->name = $request->input('name');
        $user->active = $request->input('active');
        $user->save();

        $roles = $request->input('role');
        $fetchRoles = Role::whereIn('id', $roles)->get();
        $assignRoles = [];

        foreach ($fetchRoles as $role) {
            $assignRoles[] = $role->name;
        }

        DB::table('user_has_roles')->where('user_id', $user->id)->delete();
        $user->assignRole($assignRoles);

        flash('User updated successfully.');
        event(new UserEdited($user));
        return redirect()->back();
    }

    /**
     * Handling the request to create a new user.
     *
     * @param SaveNewUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddNewUser(SaveNewUserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'active' => $request->input('active'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->assignRole($request->input('roles'));

        if (!$user->hasRole('auth user')) {
            $user->assignRole('auth user');
        }

        $profile = Profile::create([
            'user_id' => $user->id,
            'country' => 'India',
            'designation' => 'Manager',
            'options' => ['sidebar' => true]
        ]);

        event(new UserCreated($user));

        flash('User created');
        return redirect()->back();
    }

    public function getSettingsPage()
    {
        $settings = \Setting::all();
        return view('inferno-foundation::manage-settings', compact('settings'));
    }

    /**
     * Handling the save of settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveSettings(Request $request)
    {
        $postData = $request->all();
        unset($postData['_token']);
        foreach ($postData as $key => $value) {
            if ($value === 'true' || $value === 1) {
                $value = true;
            }

            if ($value === 'false' || $value === 0) {
                $value = false;
            }

            \Setting::set($key, $value);
        }
        \Setting::save();
        flash('Settings were saved successfully');
        return redirect()->back();
    }

    /**
     * Handling the request to add a new setting.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddNewSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
        ]);

        $value = $request->input('value');
        $key = $request->input('name');
        if ($value === 'true' || $value === 1) {
            $value = true;
        }

        if ($value === 'false' || $value === 0) {
            $value = false;
        }

        if ($validator->fails()) {
            flash('Error in form', 'warning');
            return redirect(route('manage-settings'))->withErrors($validator)->withInput();
        }

        \Setting::set($key, $value);
        \Setting::save();
        event(new SettingsCreated($key, $value));

        flash('Setting added');
        return redirect()->back();
    }
}
