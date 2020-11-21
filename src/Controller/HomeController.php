<?php

namespace Controller;

use DB\Conection;
use View\View;

class HomeController
{
    public function index()
    {
        // $pdo = Conection::getInstance();

        $view = new View('site/index.phtml');

        return $view->render();
    }
}