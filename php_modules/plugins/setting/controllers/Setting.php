<?php
/**
 * SPT software - homeController
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 * 
 */

namespace App\plugins\setting\controllers;

use SPT\MVC\JDIContainer\MVController;

class Setting extends MVController
{
    public function form()
    {
        $this->isLoggedIn();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.setting.form');
        $this->app->set('page', 'backend');
    }

    public function save()
    {
        $this->isLoggedIn();
        $fields = [];
        foreach ($this->plugin as $name => $plg)
        {
            if (method_exists($plg, 'registerSetting'))
            {
                $register = $plg->registerSetting();
                if (is_array($register))
                {
                    foreach ($register as $item)
                    {
                        $fields = array_merge($fields, $item['fields']);
                    }
                }
            }
        }
        $try = true;
        foreach ($fields as $key => $value)
        {
            $try = $this->OptionModel->set($key, $this->request->post->get($key, '', 'string'));
            if (!$try) break;
        }

        $msg = $try ? 'Save Done.' : 'Save Fail';
        $this->session->set('flashMsg', $msg);
        $this->app->redirect( $this->router->url('admin/setting'));
    }

    public function isLoggedIn()
    {
        if( !$this->user->get('id') )
        {
            $this->app->redirect(
                $this->router->url(
                    'admin/login'
                )
            );
        }
    }
}