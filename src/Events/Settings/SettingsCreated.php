<?php

namespace Inferno\Foundation\Events\Settings;

class SettingsCreated
{
    protected $string;

    /**
     * SettingsCreated constructor.
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->string = 'A new setting ' . $key . ' with value ' . $value;
    }

    public function getString()
    {
        return $this->string;
    }
}