<?php

namespace Inferno\Foundation\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Inferno\Foundation\Models\Profile;
use Spatie\Permission\Models\Role;

class InfernoUserSeeder extends Seeder
{
	protected $adminRole, $authUser;

	/**
	 * The main function which will be executed when called.
	 */
	public function run()
	{
		$this->addRoles();
		$this->createUser();
	}

	/**
	 * This function will add default roles.
	 */
	protected function addRoles()
	{
		$this->adminRole = Role::where('name', 'admin')->first();

		if (!$this->adminRole) {
			$this->adminRole = Role::create(['name' => 'admin']);
		}

		$this->authUser = Role::where('name', 'auth user')->first();

		if (!$this->authUser) {
			$this->authUser = Role::create(['name' => 'auth user']);
		}
	}

	/**
	 * This function will create two default user.
	 */
	public function createUser()
	{
		if (User::where('email', 'admin@admin.com')->first()) {
			return true;
		}

		$adminUser = User::create([
			'name' => 'Admin',
			'email' => 'admin@admin.com',
			'password' => bcrypt('password'),
			'active' => 1,
		]);

		$profile = Profile::create([
		    'user_id' => $adminUser->id,
		    'country' => 'India',
		    'designation' => 'Manager',
		    'options' => ['sidebar' => true]
		]);

		$adminUser->assignRole(['admin']);
	}
}
