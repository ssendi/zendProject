<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->redirect('index/index');
        }
        $request = $this->getRequest();
        $form = new Application_Form_Login();
        if($request->isPost())
        {
            if($form->isValid($this->_request->getPost())){
                $username = $form->getValue("username");
                $password = $form->getValue("password");
                $usersTable =  new Application_Model_User();
                $user = $usersTable->getUserByUsername($username);
                if($user)
                {
                    if($this->passwordCheck($password,$user["password"]))
                    {
                        $auth = Zend_Auth::getInstance();
                        $authStorage = $auth->getStorage();
                        $authStorage->write($user);
                        $this->redirect('authentication/login');
                    }
                }
                $this->view->assign('errorMessage','The combination of username and password is not valid');
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect("index/index");
    }

    public function registerAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->redirect('index/index');
        }
        $request = $this->getRequest();
        $form = new Application_Form_Register();
        if($request->isPost())
        {
            if($form->isValid($this->_request->getPost())){
                $username = $form->getValue("username");
                $password = $this->passwordEncrypt($form->getValue("password"));
                $user = new Application_Model_Register();
                $user->createUser(array(
                    "username" => $username,
                    "password" => $password
                ));
                $this->redirect('index/index');
            }
        }
        $this->view->form = $form;
    }

    private function passwordEncrypt($password)
    {
        $hashFormat = "$2y$10$";
        $saltLength = 22;
        $salt = $this->generateSalt($saltLength);
        $formatAndSalt = $hashFormat . $salt;
        $hash = crypt($password,$formatAndSalt);
        return $hash;
    }

    private function generateSalt($length)
    {
        $uniqueRandomString = md5(uniqid(mt_rand(),true));
        $base64String = base64_encode($uniqueRandomString);
        $modifiedBase64String = str_replace('+','.',$base64String);
        $salt = substr($modifiedBase64String,0,$length);
        return $salt;
    }

    private function passwordCheck($password, $existingHash)
    {
        $hash = crypt($password,$existingHash);
        if($hash === $existingHash)
        {
            return true;
        }else
        {
            return false;
        }
    }
}

/*private function getAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password');
        return $authAdapter;
    }*/

/*
public function loginAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->redirect('index/index');
        }
        $request = $this->getRequest();
        $form = new Application_Form_Login();
        if($request->isPost())
        {
            if($form->isValid($this->_request->getPost())){
                $authAdapter = $this->getAuthAdapter();
                $username = $form->getValue("username");
                $password = $form->getValue("password");
                $authAdapter->setIdentity($username)
                            ->setCredential($password);
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if ($result->isValid())
                {
                    $user = $authAdapter->getResultRowObject();
                    $authStorage = $auth->getStorage();
                    $authStorage->write($user);
                    $this->redirect('authentication/login');
                }else
                {
                    echo "The combination of username and password is not valid";
                }
            }
        }
        $this->view->form = $form;
    }

 */
