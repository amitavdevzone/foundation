<?php

namespace Inferno\Foundation\Presenters;

use Illuminate\Support\Facades\Auth;
use Inferno\Foundation\Models\Profile;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
	public function profilePic()
	{
		$profile = Profile::where('user_id', Auth::user()->id)->first();
		if ($profile->profile_pic != null && $profile->profile_pic != '') {
		    return $profile->profile_pic;
		} else {
			$assetPath = config('foundation.assets_path');
		    return url($assetPath . '/img/avatar.png');
		}
	}

	/**
	 * This function will return the time since the user is a memeber
	 * by calculating the time the user was created from.
	 */
	public function memberSince()
	{
		$user = Auth::user();
		$createdAt = $user->created_at;
		return $createdAt->format('F, Y');
	}
}
