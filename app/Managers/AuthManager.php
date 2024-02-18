<?php

namespace App\Managers;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Auth;

class AuthManager
{
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }


    public function guard()
    {
        return Auth::guard();
    }
}
