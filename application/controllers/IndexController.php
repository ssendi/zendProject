<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    }
}

/*
public function indexAction()
    {
        $user = new Application_Model_User();
        $users = $user->getAllUsers();
        var_dump($users);
    }

    public function createUser()
    {
        $register = new Application_Model_Register();
        $register->createUser(array(
            'username'  => "sendy",
            'password'  => "sendy",
            'token'     => "sendy",
            'name'      => "sendy",
            'surname'   => "sendy"
        ));
    }

*/