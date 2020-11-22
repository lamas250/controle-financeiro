<?php

namespace Controller;

use View\View;
use Entity\User;
use DB\Conection;
use Authenticator\Authenticator;
use Session\Flash;

class AuthController
{
    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user = new User(Conection::getInstance());
            $authenticator = new Authenticator($user);

            if(!$authenticator->login($_POST)){
                Flash::add("danger","Erro ao logar.");
                return header("Location: " . HOME . 'auth/login');
            }
            Flash::add("success","Usuário logado com sucesso!");
            return header("Location: " . HOME . 'myexpenses');
        }
        $view = new View('auth/index.phtml');

        return $view->render();
    }

    public function logout()
    {
        $auth = (new Authenticator())->logout();
        
        Flash::add("success","Usuário deslogado com sucesso!");
        return header("Location: " . HOME . 'auth/login');
    }
}