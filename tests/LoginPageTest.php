<?php

namespace Inferno\Foundation\Tests;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
	protected $path, $loginBtn;

	/**
	 * Handling the construct
	 */
	public function __construct()
	{
		$this->path = '/login';
		$this->loginBtn = '.btn.btn-primary.btn-block.btn-flat';
	}

    public function test_login_page_is_available()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->path)
                ->assertSee('Hell awaits you');
        });
    }

    public function test_blank_username_and_password_validation_is_done()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->path)
            	->type('email', '')
            	->type('password', '')
            	->click($this->loginBtn)
            	->assertPathIs($this->path)
            	->assertSee('The email field is required.')
            	->assertSee('The password field is required.');
        });
    }

    public function test_wrong_password_fails_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->path)
            ->type('email', 'admin@admin.com')
            ->type('password', 'wrongpassword')
            ->click($this->loginBtn)
            ->assertPathIs($this->path)
            ->assertSee('These credentials do not match our records.');
        });
    }

    public function test_logged_in_user_should_not_see_login_page()
    {
        $this->browse(function (Browser $browser) {
        	$user = User::where('email', 'admin@admin.com')->first();
            $browser->loginAs(User::find($user->id))
            	->visit($this->path)
            	->assertPathIs('/home');
        });
    }
}
