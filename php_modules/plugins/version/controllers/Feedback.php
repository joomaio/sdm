<?php
/**
 * SPT software - homeController
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 * 
 */

namespace App\plugins\version\controllers;

use SPT\MVC\JDIContainer\MVController;

class Feedback extends Admin 
{
    public function list()
    {
        $this->validateVersionID();
        $this->isLoggedIn();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.feedback.list');
    }

    public function validateVersionID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['version_id'];

        if(empty($id))
        {
            $this->session->set('flashMsg', 'Invalid Version');
            return $this->app->redirect(
                $this->router->url('versions'),
            );
        }

        return $id;
    }
}