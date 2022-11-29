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

use App\plugins\user\controllers\Admin;

class User extends Admin
{
    public function list()
    {
        $this->isAdmin();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.user.list');
        $this->app->set('page', 'backend');
    }

    public function detail()
    {
        $this->isAdmin();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.user.form');
        $this->app->set('page', 'backend');
    }

    public function add()
    {
        $this->isAdmin();

        $this->isLoggedIn();

        //check confirm password
        if($this->request->post->get('password', '') != $this->request->post->get('confirm_password', ''))
        {
            $this->app->redirect(
                $this->router->url('admin/user/0'), 'Error: Confirm Password Failed'
            );
        }

        // TODO: validate new add
        $newId =  $this->UserEntity->add([
            'name' => $this->request->post->get('name', '', 'string'),
            'username' => $this->request->post->get('username', '' , 'string'),
            'email' => $this->request->post->get('email', '' , 'string'),
            'password' => md5($this->request->post->get('password', '')),
            'status' => $this->request->post->get('status', '') == "" ? 0 : 1,
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);

        if( !$newId )
        {
            $msg = 'Error: Save Failed';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/user/0'), $msg
            );
        }
        else
        {
            $this->app->redirect(
                $this->router->url('admin/users'), 'Save Successfully'
            );
        }

        
    }

    public function update()
    {
        $id = $this->validateID(); 

        $password = $this->request->post->get('password', '');
        $repassword = $this->request->post->get('confirm_password', '');

        $user = [
            'name' => $this->request->post->get('name', '', 'string'),
            'username' => $this->request->post->get('username', '' , 'string'),
            'email' => $this->request->post->get('email', '', 'string'),
            'status' => $this->request->post->get('status', '') == "" ? 0 : 1,
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s'),
            'id' => $ids,
        ];

        if (!$this->UserModel->validate($user))
        {
            $this->session->set('flashMsg', 'Error: Confirm Password Failed');
            $this->app->redirect(
                $this->router->url('admin/user/'.$ids), 
            ); 
        }
        

        if($password) 
        {
            $user['password'] = $this->request->post->get('password', '');

            if($password == $repassword) 
            {
                $user = [
                    'name' => $this->request->post->get('name', '', 'string'),
                    'username' => $this->request->post->get('username', '' , 'string'),
                    'email' => $this->request->post->get('email', '', 'string'),
                    'status' => $this->request->post->get('status', '') == "" ? 0 : 1,
                    'modified_by' => $this->user->get('id'),
                    'modified_at' => date('Y-m-d H:i:s'),
                    'id' => $ids,
                ];
            }
            else
            {
                $this->app->redirect(
                    $this->router->url('admin/user/'.$ids), 'Error: Confirm Password Failed'
                );
            }

            $passwrd =  $this->request->post->get('password','');
            if($passwrd) $user['password'] = md5($passwrd);
            
            $try = $this->UserEntity->update( $user );

            if($try) 
            {
                $this->app->redirect(
                    $this->router->url('admin/users'), 'Edit Successfully'
                );
            }
            else
            {
                $msg = 'Error: Save Failed';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('admin/userUpdate/'. $ids), $msg
                );
            }
    }

    public function delete()
    {
        $this->isAdmin();
        $this->validateToken();

        $id = $this->validateId();

        if ($id && !is_array($id))
        {
            $try = $this->UserEntity->remove($id);
            
            if ($try)
            {
                $this->IPLoginEntity->remove_bulks($id, 'u_id');
                $this->session->set('flashMsg', "Delete of user id ". $id." was successful");
            }
            else
            {
                $this->session->set('flashMsg', "Delete of user id ". $id." fail");
            }
        }
        elseif(is_array($id))
        {
            $count = 0;
            foreach ($id as $item)
            {
                $try = $this->UserEntity->remove($id);
                $this->IPLoginEntity->remove_bulks($id, 'u_id');
                $count = $try ? $count + 1 : $count;
            }

            $this->session->set('flashMsg', "Delete ". $count." user was successful");
        }

        $this->app->redirect(
            $this->router->url('admin/users'),
        );
    }

    public function validateId()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        if(empty($id))
        {
            $id = $this->request->post->post('ids', [], 'array');
            if (!$id)
            {
                $this->session->set('flashMsg', 'Invalid User');

                $this->app->redirect(
                    $this->router->url('admin/users'),
                );
            }
        }

        return $id;
    }
}