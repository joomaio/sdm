<?php
/**
 * SPT software - homeController
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 * 
 */

namespace App\plugins\note\controllers;

use SPT\MVC\JDIContainer\MVController;

class Setting extends Admin
{
    public function connections()
    {
        $this->isLoggedIn();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.setting.connections');
        $this->app->set('page', 'backend');
    }

    public function connectionsSave()
    {
        $this->isLoggedIn();
        $fields = [
            'folder_id',
            'client_id',
            'client_secret',
            'access_token',
        ];

        $try = true;
        foreach ($fields as $key)
        {
            $try = $this->OptionModel->set($key, $this->request->post->get($key, '', 'string'));
            if (!$try) break;
        }

        $msg = $try ? 'Save Done.' : 'Save Fail';
        $this->session->set('flashMsg', $msg);
        return $this->app->redirect( $this->router->url('setting-connections'));
    }
}