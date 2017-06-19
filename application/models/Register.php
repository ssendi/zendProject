<?php

class Application_Model_Register
{
    public function createUser($array)
    {
        $dbTableUser = new Application_Model_DbTable_User();
        $dbTableUser->insert($array);
    }
}

