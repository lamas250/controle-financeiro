<?php

namespace Authenticator;

use Session\Session;

class Authenticator
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(array $credentials)
    {
        $user = $this->user->where([
            'email' => $credentials['email'],
        ]);

        if(!$user){
            return false;
        }

        if($user['password'] != $credentials['password']){
            return false;
        }
        unser($user['password']);
        Session::add('user',$user);
        return true;
    }

    public function logout()
    {
        if(Session::has('user')){
            Session::remove('user');
        }
    }
}