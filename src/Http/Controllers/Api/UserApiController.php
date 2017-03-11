<?php

namespace Inferno\Foundation\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Inferno\Foundation\Http\Controllers\Controller;

class UserApiController extends Controller
{
	/**
	 * This is the function to toggle the user's preference
	 * of sidebar toggle.
	 */
	public function postSidebarToggle(Request $request)
	{
		$userId = $request->user()->id;
        $user = User::where('id', $userId)->with('profile')->first();
        $options = $user->profile->options;
        \Log::info(print_r($user->toArray(), 1));

        if (isset($options['sidebar'])) {
            $options['sidebar'] = !$options['sidebar'];
        } else {
        	$options['sidebar'] = false;
        }

        $user->profile->options = $options;
        $user->profile->save();

        return response(['data' => $user], 200);
	}
}
