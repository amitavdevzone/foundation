<?php

namespace Inferno\Foundation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	/**
	 * This function will return the home page for the user
	 * when the user is logged in successfully.
	 */
	public function getHomePage()
	{
		return view('inferno-foundation::home');
	}

	/**
	 * This is the function to logout the user
	 */
	public function postLogout(Request $request)
	{
		Auth::logout();
		flash('You have been logged out');
		return redirect('/');
	}
}
