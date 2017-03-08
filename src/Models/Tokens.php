<?php

namespace Inferno\Foundation\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'token', 'created_at', 'expiry_at', 'type'];

    /**
     * Setting up the Token and User relationship.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Mutator for Token created time.
     */
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::now();
    }

    /**
     * Mutator for Token expiry time which is taken from env or else
     * by default 24 hours.
     */
    public function setExpiryAtAttribute($value)
    {
        $expiry = env('TOKEN_EXPIRY', 24);
        $this->attributes['expiry_at'] = Carbon::now()->addHours($expiry);
    }

    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = uniqid();
    }
}
