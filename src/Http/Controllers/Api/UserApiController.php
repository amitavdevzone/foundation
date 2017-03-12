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

        if (isset($options['sidebar'])) {
            $options['sidebar'] = !$options['sidebar'];
        } else {
        	$options['sidebar'] = false;
        }

        $user->profile->options = $options;
        $user->profile->save();

        return response(['data' => $user], 200);
	}

    /**
     * This is the function to upload the image coming from croppie.
     */
    public function postUploadProfilePic(Request $request)
    {
        $data = $request->input('img');
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $imageName = time().'.png';
        $path = public_path('profile_pics/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        file_put_contents($path . $imageName, $data);

        $imageUrl = url('profile_pics/' . $imageName);
        $user = User::with('profile')->find($request->user()->id);
        $user->profile->removeCurrentProfilePic($user);
        $user->profile->profile_pic = $imageUrl;
        $user->profile->save();

        return response(['data' => $imageUrl], 201);
    }
}
