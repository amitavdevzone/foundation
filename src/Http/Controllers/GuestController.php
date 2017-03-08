<?php 

namespace Inferno\Foundation\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * This is the function to return the login page.
     */
    public function postLogin(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required|min:6'
    	]);

        return $request->all();
    }
}
