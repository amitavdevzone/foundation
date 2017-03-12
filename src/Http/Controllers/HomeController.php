<?php

namespace Inferno\Foundation\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inferno\Foundation\Events\User\PasswordChanged;
use Inferno\Foundation\Http\Requests\ChangePasswordRequest;
use Inferno\Foundation\Http\Requests\UpdateProfileRequest;

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

    /**
     * This function will return the User's profile page.
     */
    public function pageUserProfile()
    {
        return view('inferno-foundation::user-profile');
    }

    /**
     * Handling the User's profile update.
     */
    public function postUpdateProfile(UpdateProfileRequest $request)
    {
        $user = User::with('profile')->find($request->user()->id);
        $user->name = $request->input('name');
        $user->save();

        // saving all profile fields also. Not checking if there is a change
        $user->profile->country = $request->input('country');
        $user->profile->twitter = $request->input('twitter');
        $user->profile->facebook = $request->input('facebook');
        $user->profile->skype = $request->input('skype');
        $user->profile->linkedin = $request->input('linkedin');
        $user->profile->designation = $request->input('designation');
        $user->profile->save();

        flash('Profile saved', 'info');
        return redirect()->back();
    }

    /**
     * This function will handle the request for a user to change password
     * from profile page.
     */
    public function postHandlePasswordChange(ChangePasswordRequest $request)
    {
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');

        $credentials = [
            'email' => Auth::user()->email,
            'password' => $currentPassword
        ];

        if (Auth::attempt($credentials)) {
            Auth::user()->password = bcrypt($confirmPassword);
            Auth::user()->save();

            event(new PasswordChanged());
            flash('Your password is now changed.');
            return redirect()->back();
        }

        flash('Check if your current password is correct.', 'warning');
        return redirect()->back();
    }
}
