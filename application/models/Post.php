<?php

class Application_Model_Post extends Zend_Db_Table_Abstract
{
    public function getAllBlogs()
    {
        //$postsTable = Zend_Db::factory($this->_setAdapter($this->_db));
        $postsTable = new Application_Model_DbTable_Post();
        $postsSQL = $postsTable->select()->setIntegrityCheck(false)
            ->from(array('p' => 'posts'), array('id', 'title', 'body'))
            ->joinLeft(array('c' => 'categories'), 'c.id = p.category_id',
                array('categoryName' => 'name'))
            ->joinLeft(array('u' => 'users'), 'u.id = p.user_id',
                array('username' => 'username'));
        $posts = $postsTable->fetchAll($postsSQL)->toArray();
        return $posts;
    }

    public function getPostByID($id)
    {
        $postTable = new Application_Model_DbTable_Post();
        $post = $postTable->find($id);
        if (count($post) > 0) {
            return $post->toArray()[0];
        }
        return false;
    }

    public function getPostsByUserID($userID)
    {
        $postsTable = new Application_Model_DbTable_Post();
        $postsSQL = $postsTable->select()->setIntegrityCheck(false)
            ->from(array('p' => 'posts'), array('id', 'title', 'body'))
            ->joinLeft(array('c' => 'categories'), 'c.id = p.category_id',
                array('categoryName' => 'name'))
            ->joinLeft(array('u' => 'users'), 'u.id = p.user_id',
                array('username' => 'username'))
            ->where('p.user_id = ?', $userID);
        $posts = $postsTable->fetchAll($postsSQL)->toArray();
        return $posts;
    }

    public function createPost($array)
    {
        $dbTablePost = new Application_Model_DbTable_Post();
        $dbTablePost->insert($array);
    }

    public function updatePost($post, $id)
    {
        $dbTablePost = new Application_Model_DbTable_Post();
        $where = $dbTablePost->getAdapter()->quoteInto('id = ?', $id);
        $dbTablePost->update($post, $where);
    }

    public function deletePost($id)
    {
        $dbTablePost = new Application_Model_DbTable_Post();
        $where = $dbTablePost->getAdapter()->quoteInto('id = ?', $id);
        $dbTablePost->delete($where);
    }
}