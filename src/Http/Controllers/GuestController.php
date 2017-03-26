<?php

namespace Inferno\Foundation\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inferno\Foundation\Events\User\Login;
use Inferno\Foundation\Mail\ForgotPasswordMail;
use Inferno\Foundation\Models\Tokens;

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
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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

        $token = Tokens::create([
            'user_id' => $user->id,
            'token' => uniqid(),
            'created_at' => Carbon::now(),
            'expiry_at' => Carbon::now()->addHour(),
            'type' => 'forgot-password',
        ]);

        Mail::to($user)->send(new ForgotPasswordMail($token, $request));

        flash('An email has been sent to your id');
        return redirect()->route('login');
    }

    /**
     * Handling the page for the reset password form.
     *
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getResetPassword($token)
    {
        return view('inferno-foundation::reset-password',compact('token'));
    }

    public function postChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            flash('Both passwords are not same', 'warning');
            return redirect()->back();
        }

        $token = $request->input('token');
        $dBToken = DB::table('tokens')
            ->where('token', $token)
            ->where('expiry_at', '>', Carbon::now())
            ->first();

        if (!$dBToken) {
            flash('Something went wrong', 'warning');
            return redirect()->back();
        }

        $user = User::where('id', $dBToken->user_id)->first();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        DB::table('tokens')->where('id', $dBToken->id)->delete();

        flash('Password changes successfully');
        return redirect()->route('login');
    }
}
