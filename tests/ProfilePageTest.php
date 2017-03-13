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
            // $browser->visit($this->path)->;
        });
    }
}
