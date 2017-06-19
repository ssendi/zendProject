<?php

class PostController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $postModel = new Application_Model_Post();
        $posts = $postModel->getAllBlogs();
        $this->view->assign('data',$posts);
    }
    
    public function mypostsAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $this->redirect('authentication/login');
        }
        $user = Zend_Auth::getInstance()->getStorage()->read();
        $postModel = new Application_Model_Post();
        $userPosts = $postModel->getPostsByUserID($user["id"]);
        $this->view->assign('data',$userPosts);
    }
    
    public function createAction()
    {
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Application_Model_Post();
            $user = Zend_Auth::getInstance()->getStorage()->read();
            $post->createPost(array(
                "title"         => $request->getParam('title'),
                "body"          => $request->getParam('body'),
                "category_id"   => $request->getParam('category_id'),
                "user_id"       => $user["id"]
            ));
            $this->redirect('post/myposts');
        }
        $categoryObj = new Application_Model_Category();
        $categories = $categoryObj->getAllCategories();
        $this->view->assign('categories', $categories);
    }

    public function updateAction()
    {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->getStorage()->read();
        if($request->isPost())
        {
            $post = new Application_Model_Post();
            //$user = Zend_Auth::getInstance()->getStorage()->read();
            $post->updatePost(array(
                "title"         => $request->getParam('title'),
                "body"          => $request->getParam('body'),
                "category_id"   => $request->getParam('category_id'),
                "user_id"       => $user["id"]
            ),$request->getParam("id"));
            $this->redirect('post/myposts');
        }
        // get all categories for dropDown
        $categoryObj = new Application_Model_Category();
        $categories = $categoryObj->getAllCategories();
        $this->view->assign('categories', $categories);

        //getPost
        $postObj = new Application_Model_Post();
        $post = $postObj->getPostByID($request->getParam("id"));
        if($user["id"] == $post["user_id"])
        {
            $this->view->assign('post', $post);
        }
        else
        {
            $this->redirect('post/myposts');
        }
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->getStorage()->read();
        $id = $request->getParam("id");
        $postObj = new Application_Model_Post();
        $post = $postObj->getPostByID($id);
        if($post["user_id"] == $user["id"])
        {
            $postObj->deletePost($id);
        }
        $this->redirect('post/myposts');
    }
}

