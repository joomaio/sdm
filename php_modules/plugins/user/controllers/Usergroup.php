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

use SPT\Middleware\Dispatcher as MW;

class Usergroup extends Admin 
{
    public function list()
    {
        $this->isLoggedIn();
        
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.usergroup.list');
        $this->app->set('page', 'backend');
    }

    public function detail()
    {
        $this->isLoggedIn();
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        
        $this->app->set('layout', 'backend.usergroup.form');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    } 

    public function add()
    {
        $this->isLoggedIn();
        
        $try = MW::fire('validation', ['ValidateGroup'], []);
        if (!$try)
        {
            $msg = $this->session->get('validate', '');
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/user-group/0')
            );
        }
        // TODO: validate new add
        $status = $this->request->post->get('status', 0, 'string');
        $newId =  $this->GroupEntity->add([
            'name' => $this->request->post->get('name', '', 'string'),
            'description' => $this->request->post->get('description', '', 'string'),
            'access' => json_encode($this->request->post->get('access', [], 'array')),
            'status' => $status,
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);
        
        if( !$newId )
        {
            $msg = 'Error: Creat Failed';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/user-group/0')
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Creat Success');
            $this->app->redirect(
                $this->router->url('admin/user-groups')
            );
        }
    }

    public function update()
    {
        $sth = $this->validateId(); 
        
        if( is_array($sth) )
        {
            // publishment
            $count = 0;
            $action = $this->request->post->get('published', '', 'string');

            foreach($sth as $id)
            {
                if( $this->GroupEntity->toggleActive($id, $action) )
                {
                    $count++;
                }
           }

            $this->session->set('flashMsg', $count.' changed record(s)');
            $this->app->redirect( $this->router->url('admin/user-groups'));

        }
        elseif( is_numeric($sth) )
        {   
            $try = MW::fire('validation', ['ValidateGroup'], []);
            if (!$try)
            {
                $msg = $this->session->get('validate', '');
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('admin/user-group/'.$sth)
                );
            }

            $status = $this->request->post->get('status', 0, 'string');
            $user = [
                'name' => $this->request->post->get('name', '', 'string'),
                'description' => $this->request->post->get('description', '', 'string'),
                'access' => json_encode($this->request->post->get('access', [], 'array')),
                'status' => $status,
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $sth,
            ];
            $try = $this->GroupEntity->update( $user );
    
            $msg = $try ? 'Edit Success' : 'Edit Failed';
            $this->session->set('flashMsg', $msg);
    
            if ($try)
            {
                $this->app->redirect(
                    $this->router->url('admin/user-groups')
                );
            }
            else
            {
                $this->app->redirect(
                    $this->router->url('admin/user-group/'.$sth)
                );
            }
            
        }

            $this->session->set('flashMsg', 'Error: Invalid request');
            $this->app->redirect(
            $this->router->url('admin/user-groups')
        );
    }

    public function delete()
    {
        $sth = $this->validateID();
        
        $count = 0;

        if( is_array($sth))
        {
            foreach($sth as $id)
            {
                if( $this->GroupEntity->remove( $id ) )
                {
                    $count++;
                }
            }
        }
        elseif( is_numeric($sth) )
        {
            if( $this->GroupEntity->remove($sth ) )
            {
                $count++;
            }
        }  

        $this->session->set('flashMsg', $count.' deleted record(s)');
        $this->app->redirect( $this->router->url('admin/user-groups'));
    }

    public function validateID()
    {
        $this->isLoggedIn();
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        if(empty($id) && !$id)
        {
            $ids = $this->request->post->get('ids', [], 'array');
            if(count($ids)) return $ids;

            $this->session->set('flashMsg', 'Invalid user group');
            $this->app->redirect(
                $this->router->url('admin/user-groups')
            );
        }

        return $id;
    }
}
