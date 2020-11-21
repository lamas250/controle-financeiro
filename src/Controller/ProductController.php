<?php

namespace Controller;

use DB\Conection;
use View\View;
use Entity\Product;

class ProductController
{
    public function index($id)
    {
        // $id = (int) $id;
        
        $pdo = Conection::getInstance();

        $view = new View('site/single.phtml');
        $view->product = (new Product($pdo))->find($id);

        return $view->render();
    }
}