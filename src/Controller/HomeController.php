<?php

namespace Controller;

use DB\Conection;
use View\View;
use Entity\Product;

class HomeController
{
    public function index()
    {
        $pdo = Conection::getInstance();

        $view = new View('site/index.phtml');
        $view->products = (new Product($pdo))->findAll();

        return $view->render();
    }
}