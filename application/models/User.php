<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{
    public function getAllUsers()
    {
        $usersTable = new Application_Model_DbTable_User();
        $users = $usersTable->fetchAll();
        return $users;
    }

    public function getUserByUsername($username)
    {

        $usersTable = new Application_Model_DbTable_User();
        $users = $usersTable->select()
                            ->from('users')
                            ->where("username = ?",$username);
        $users = $usersTable->fetchAll($users)->toArray();
        if(count($users)>0){
            return $users[0];
        }
        return false;
    }
}

/* $stmt = $db->query('SELECT * FROM bugs WHERE reported_by = ? AND bug_status = ?',array('goofy', 'FIXED'));*/