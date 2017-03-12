<?php

namespace Inferno\Foundation\Models;

use Illuminate\Database\Eloquent\Model;

class Watchdog extends Model
{
	protected $fillable = ['description', 'level', 'user_id', 'ip_address'];
}
