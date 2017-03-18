<?php

namespace Inferno\Foundation\Test;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EditUserPageTest extends DuskTestCase
{
    protected $pageUrl;
    /**
     * Setting things.
     */
    public function __construct()
    {

    }

    /**
     * Get the admin user.
     */
    protected function get_admin_user()
    {
        $users = User::role('admin')->get();
        return $users[0];
    }

    /**
     * Get the normal user.
     */
    protected function get_normal_user()
    {
        $users = User::role('auth user')->get();
        return $users[0];
    }

    public function test_normal_user_cannot_see_edit_user_page()
    {
        $user = $this->get_admin_user();
        $url = '/admin/user/edit/' . $user->id;
        $normalUser = $this->get_normal_user();

        $this->browse(function (Browser $browser) {
            // $browser->loginAs(User::find(5))
            //     ->visit('/admin/user/edit/5')
            //     ->assertSee('abort(403');
        });
    }
}
