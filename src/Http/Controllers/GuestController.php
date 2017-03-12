<?php

namespace Inferno\Foundation\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Inferno\Foundation\Events\User\Login;

class GuestController extends Controller
{
    use AuthenticatesUsers;
    /**
     * This is the function to handle the request for login.
     */
    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCustomCredentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            event(new Login);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
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
