<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    public function getAllCategories()
    {
        $categoryTable = new Application_Model_DbTable_Category();
        $categories = $categoryTable->fetchAll();
        return $categories->toArray();
    }
}