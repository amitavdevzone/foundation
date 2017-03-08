<?php 

namespace Inferno\Foundation\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * This is the function to handle the request for login.
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        return $request->all();
    }

    /**
     * This function will return the forgot password page.
     */
    public function getForgotPassword()
    {
        return view('inferno-foundation::forgot-password');
    }

    /**
     * This function will handle the request to enter email address
     * and receive the forgot password link by email.
     */
    public function postSendForgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            flash('This email address is not in our records.', 'warning');
            return redirect()->back();
        }
    }
}
