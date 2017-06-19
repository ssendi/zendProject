<?php

class Application_Form_Login extends Zend_Form
{

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->setName('login');
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('User name: ')->setAttrib("style","color: black;")
                 ->setRequired();

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password: ')->setAttrib("style","color: black;")
                 ->setRequired(true);

        $login = new Zend_Form_Element_Submit('login');
        $login->setLabel('Login')->setAttrib("style","color: black;");

        $this->addElements(array($username,$password, $login));
        $this->setMethod('post');
        $this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() .'/authentication/login');
    }


}

