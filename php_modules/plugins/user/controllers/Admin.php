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
    public function isLoggedIn()
    {
        if( !$this->user->get('id') )
        {
            return $this->app->redirect(
                $this->router->url(
                    'login'
                )
            );
        }
    }

}