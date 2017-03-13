<?php

namespace Inferno\Foundation\Test;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfilePageTest extends DuskTestCase
{
	protected $path, $loginBtn;

	/**
	 * Handling the construct
	 */
	public function __construct()
	{
		$this->path = '/user/profile';
		$this->changePasswordBtn = '#change-password-form .btn-success';
	}

    public function test_change_password_without_data_validation_error()
    {
        $this->browse(function (Browser $browser) {
        	$user = User::where('email', 'admin@admin.com')->first();
            $browser->loginAs(User::find($user->id))
            	->visit($this->path)
            	->type('current_password', '')
            	->type('new_password', '')
            	->type('confirm_password', '')
            	->click($this->changePasswordBtn)
            	->assertPathIs($this->path)
            	->assertSee('The current password field is required.')
            	->assertSee('The new password field is required.')
            	->assertSee('The confirm password field is required.');
        });
    }

    public function test_without_current_password_show_validations()
    {
        $this->browse(function (Browser $browser) {
        	$user = User::where('email', 'admin@admin.com')->first();
            $browser->loginAs(User::find($user->id))
            	->visit($this->path)
            	->type('new_password', 'Password1')
            	->type('confirm_password', 'Password1')
            	->click($this->changePasswordBtn)
            	->assertPathIs($this->path)
            	->assertSee('The current password field is required.');
        });
    }

    public function test_wrong_password_does_not_allow_password_change()
    {
        $this->browse(function (Browser $browser) {
        	$user = User::where('email', 'admin@admin.com')->first();
            $browser->loginAs(User::find($user->id))
            	->visit($this->path)
            	->type('current_password', 'wrongpassword')
            	->type('new_password', 'Password1')
            	->type('confirm_password', 'Password1')
            	->click($this->changePasswordBtn)
            	->assertSee('Check if your current password is correct.');
        });
    }

    public function test_user_can_change_password_correctly_and_login_back()
    {
        $this->browse(function (Browser $browser) {
        	$user = User::where('email', 'admin@admin.com')->first();
            $browser->loginAs(User::find($user->id))
            	->visit($this->path)
            	->type('current_password', 'password')
            	->type('new_password', 'Password1')
            	->type('confirm_password', 'Password1')
            	->click($this->changePasswordBtn)
            	->assertPathIs($this->path)
            	->click('#user-dropdown-menu')
            	->click('#logout-button')
            	->assertPathIs('/')
            	->visit('/login')
            	->type('email', 'admin@admin.com')
            	->type('password', 'Password1')
            	->click('.btn.btn-primary.btn-block.btn-flat')
            	->assertPathIs('/home')
            	->visit($this->path)
            	->type('current_password', 'Password1')
            	->type('new_password', 'password')
            	->type('confirm_password', 'password')
            	->click($this->changePasswordBtn);
        });
    }
}
