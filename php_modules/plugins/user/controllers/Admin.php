<?php
/**
 * SPT software - homeController
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 * 
 */

namespace App\plugins\user\controllers;

use SPT\MVC\JDIContainer\MVController;

class Admin extends MVController
{
    public function maint()
    {
        $this->isAdmin(true);
        // write your code here
        $this->app->set('format', 'html');
        $this->app->set('layout', 'admin.maint');
    }

    public function islogged()
    {
        if ($this->user->get('u_id'))
        {
            return true;
        }
        return false;
    }

    public function login()
    {
        // write your code here

        $result = $this->user->login(
            $this->request->post->get('username', '', 'string'),
            $this->request->post->get('password', '', 'string')
        );

        if ($result) {
            $this->app->redirect(
                $this->router->url('admin')
            );
        } else {
            $this->session->set('flashMsg', 'Username or Password is NOT a valid.');
            $this->app->redirect(
                $this->router->url('admin/login')
            );
        }
    }
    
    public function gate()
    {
        if ($this->islogged() && ($this->user->get('u_type') != 'update' || $this->user->get('u_type') != 'admin')) {
            $this->app->redirect(
                $this->router->url('admin')
            );
        }
        // write your code here
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.user.login');
        $this->app->set('page', 'login');
    }

    public function logout()
    {
        $this->user->logout();
        $this->app->redirect(
            $this->router->url('admin/login')
        );
    }

    public function validateToken()
    {
        $requestToken = $this->request->post->get('token', '', 'string');
        $try = $this->app->validateToken($requestToken);
        if (!$try){
            $this->app->redirect($this->router->url());
        }
    }

    
    public function isAdmin($updater = false)
    {
        if (!$this->islogged())
        {
            
            $this->app->redirect(
                $this->router->url('admin/login')
            );
        }
        else
        {
            return true;
        }
    }
}