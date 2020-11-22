<?php

namespace Controller;

use View\View;
use Entity\User;
use DB\Conection;
use Entity\Expense;
use Entity\Category;
use Session\Session;
use Authenticator\CheckUserLogged;

class MyexpensesController
{
    use CheckUserLogged;

    public function __construct()
    {
        if(!$this->check()){
            die("PRECISA LOGAR");
        }
    }

    public function index()
    {
        $user_id = Session::get('user')['id'];

        $view = new View('expenses/index.phtml');
        $view->expenses = (new Expense(Conection::getInstance()))->where(['users_id' => $user_id]);

        return $view->render(); 
    }

    public function new()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == 'POST'){
            $data = $_POST;
            $data['users_id'] = Session::get('user')['id'];
            $expense = new Expense(Conection::getInstance());
            $expense->insert($data);

            return header('Location: ' . HOME . 'myexpenses');
        }
        $view = new View('expenses/new.phtml');

        $view->categories = (new Category(Conection::getInstance()))->findAll();

        return $view->render();
    }

    public function edit($id)
    {
        $view = new View('expenses/edit.phtml');
        $conection = Conection::getInstance();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = $_POST;
            $data['id'] = $id;

            $expense = new Expense($conection);
            $expense->update($data);

            return header('Location: ' . HOME . 'myexpenses');
        }

        $view->categories = (new Category($conection))->findAll();
        $view->users = (new User($conection))->findAll();
        $view->expense = (new Expense($conection))->find($id);

        return $view->render();
    }

    public function remove($id)
    {
        $expense = new Expense((Conection::getInstance()));
        $expense->delete($id);

        return header('Location: ' . HOME . 'myexpenses');
    }
}