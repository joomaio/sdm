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

    public function system()
    {
        $this->isLoggedIn();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.setting.system');
        $this->app->set('page', 'backend');
    }

    public function systemSave()
    {
        $this->isLoggedIn();
        $fields = [
            'admin_mail',
        ];

        $try = true;
        foreach ($fields as $key)
        {
            $try = $this->OptionModel->set($key, $this->request->post->get($key, '', 'string'));
            if (!$try) break;
        }

        $msg = $try ? 'Save Done.' : 'Save Fail';
        $this->session->set('flashMsg', $msg);
        return $this->app->redirect( $this->router->url('setting-system'));
    }

    public function smtp()
    {
        $this->isLoggedIn();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.setting.smtp');
        $this->app->set('page', 'backend');
    }

    public function smtpSave()
    {
        $this->isLoggedIn();
        $fields = [ 
            'email_host',
            'email_port',
            'email_username',
            'email_password',
            'email_from_addr',
            'email_from_name',
        ];

        $try = true;
        foreach ($fields as $key)
        {
            $try = $this->OptionModel->set($key, $this->request->post->get($key, '', 'string'));
            if (!$try) break;
        }

        $msg = $try ? 'Save Done.' : 'Save Fail';
        $this->session->set('flashMsg', $msg);
        return $this->app->redirect( $this->router->url('setting-smtp'));
    }

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

    public function testMail()
    {
        $this->isLoggedIn();

        $admin_mail = $this->OptionModel->get('admin_mail', '');
        if (!$admin_mail)
        {
            $this->session->set('flashMsg', 'Error: Enter admin email before testing');
            return $this->app->redirect( $this->router->url('setting'));
        }

        $try = $this->EmailModel->send($admin_mail, 'Admin', 'This is mail test', 'Mail Test');
        if ($try)
        {
            $this->session->set('flashMsg', 'Sent Mail Successfully');
        }
        return $this->app->redirect( $this->router->url('setting-smtp'));
    }
}