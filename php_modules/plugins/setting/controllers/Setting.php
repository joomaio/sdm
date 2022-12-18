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
        $this->app->redirect( $this->router->url('setting'));
    }

    public function isLoggedIn()
    {
        if( !$this->user->get('id') )
        {
            $this->app->redirect(
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
            $this->app->redirect( $this->router->url('setting'));
        }

        $try = $this->EmailModel->send($admin_mail, 'Admin', 'This is mail test', 'Mail Test');
        if ($try)
        {
            $this->session->set('flashMsg', 'Sent Mail Success');
        }
        $this->app->redirect( $this->router->url('setting'));
    }

    public function setTokenGoogle(){
        $redirect = $this->router->url('admin/setting/set_token_google');
        $client_id = $this->OptionModel->get('client_id', '');
        $client_secret = $this->OptionModel->get('client_secret', '');

        $googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/drive') . '&redirect_uri=' . $redirect . '&response_type=code&client_id=' . $client_id . '&access_type=online';

        if (empty($_GET['code'])){
            header("Location: $googleOauthURL");
        } else {
            $token = $this->GetAccessToken($client_id, $redirect, $client_secret, $_GET['code']);
        }

        echo 'Test authorize google';
        die();
    }

    private function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {
        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $error_msg = 'Failed to receieve access token';
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }
            throw new Exception('Error '.$http_code.': '.$error_msg);
        }

        return $data;
    }
}