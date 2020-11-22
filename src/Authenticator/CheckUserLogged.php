<?php

namespace Authenticator;

use Session\Session;

trait CheckUserLogged
{
    public function check()
    {
        if(Session::has('user')){
            return true;
        }
        return false;
    }
}