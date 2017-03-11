<?php

namespace Inferno\Foundation\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
	public function profilePic()
	{
		$assetPath = config('foundation.assets_path');
		return url($assetPath . '/img/avatar.png');
	}
}
