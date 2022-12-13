<?php
/**
 * SPT software - homeController
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 * 
 */

namespace App\plugins\milestone\controllers;

use SPT\MVC\JDIContainer\MVController;

class Task extends Admin 
{
    public function detail()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        
        $request_id = $this->validateRequestID();
        $exist = $this->TaskEntity->findByPK($id);
        if(!empty($id) && !$exist) 
        {
            $this->session->set('flashMsg', "Invalid Task");
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }
        $this->app->set('layout', 'backend.task.form');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    }

    public function list()
    {
        $this->isLoggedIn();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.task.list');
    }

    public function add()
    {
        $this->isLoggedIn();
        $request_id = $this->validateRequestID();
        //check title sprint
        $title = $this->request->post->get('title', '', 'string');
        $url = $this->request->post->get('url', '', 'string');
        $status = $this->request->post->get('status', 0, 'string');

        // TODO: validate new add
        $newId =  $this->TaskEntity->add([
            'request_id' => $request_id,
            'title' => $title,
            'status' => $status,
            'url' => $url,
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);
        
        if( !$newId )
        {
            $msg = 'Error: Create Failed!';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id .'/0')
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Create Success!');
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }
    }

    public function update()
    {
        $ids = $this->validateID(); 
        $request_id = $this->validateRequestID();
        // TODO valid the request input

        if( is_array($ids) && $ids != null)
        {
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }
        if(is_numeric($ids) && $ids)
        {
            $title = $this->request->post->get('title', '', 'string');
            $url = $this->request->post->get('url', '', 'string');
            $status = $this->request->post->get('status', 0, 'string');

            $try = $this->TaskEntity->update([
                'title' => $title,
                'url' => $url,
                'status' => $status,
                'id' => $ids,
                'created_by' => $this->user->get('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s')
            ]);
            
            if($try) 
            {
                $this->session->set('flashMsg', 'Edit Successfully');
                $this->app->redirect(
                    $this->router->url('admin/detail-request/'. $request_id), 
                );
            }
            else
            {
                $msg = 'Error: Save Failed';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('admin/detail-request/'. $request_id .'/'. $ids)
                );
            }
        }
    }

    public function delete()
    {
        $ids = $this->validateID();
        $request_id = $this->validateRequestID();
        $count = 0;
        if( is_array($ids))
        {
            foreach($ids as $id)
            {
                //Delete file in source
                if( $this->TaskEntity->remove( $id ) )
                {
                    $count++;
                }
            }
        }
        elseif( is_numeric($ids) )
        {
            if( $this->TaskEntity->remove($ids ) )
            {
                $count++;
            }
        }  
        

        $this->session->set('flashMsg', $count.' deleted record(s)');
        $this->app->redirect(
            $this->router->url('admin/detail-request/'. $request_id), 
        );
    }

    public function validateID()
    {
        $this->isLoggedIn();
        $request_id = $this->validateRequestID();
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        if(empty($id))
        {
            $ids = $this->request->post->get('ids', [], 'array');
            if(count($ids)) return $ids;

            $this->session->set('flashMsg', 'Invalid Task');
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id),
            );
        }

        return $id;
    }

    public function validateRequestID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['request_id'];

        if(empty($id))
        {
            $this->session->set('flashMsg', 'Invalid Request');
            $this->app->redirect(
                $this->router->url('admin/milestones'),
            );
        }

        return $id;
    }
}