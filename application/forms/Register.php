<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        $username = new Zend_Form_Element_Text("username");
        $username->setLabel('Username: ')->setAttrib("style","color: black;")
            ->addFilter('StripTags')
            ->addValidator(new Zend_Validate_Db_NoRecordExists('users','username'))
            ->setRequired(true);

        $password = new Zend_Form_Element_Password("password");
        $password->setLabel('Password: ')->setAttrib("style","color: black;")
            ->addFilter('StripTags')
            ->setRequired(true);

        $register = new Zend_Form_Element_Submit('register');
        $register->setLabel("Register")->setAttrib("style","color: black;");

        $this->addElements(array($username,$password, $register));
        $this->setMethod('post');
        $this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/authentication/register');
    }


}

