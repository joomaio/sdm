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

class Version extends Admin 
{
    public function list()
    {
        $this->isLoggedIn();
        $this->validateVersion();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.version_latest.list');
    }

    public function add()
    {
        $this->isLoggedIn();
        $this->validateVersion();
        //check title sprint
        $request_id = $this->validateRequestID();
        $log = $this->request->post->get('log', '', 'string');
        $version_latest = $this->VersionEntity->list(0, 1, [], 'created_at desc');
        $version_latest = $version_latest ? $version_latest[0] : [];
        if( !$version_latest )
        {
            $msg = 'Error: Invalid Version!';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }
        // TODO: validate new add
        $newId =  $this->VersionNoteEntity->add([
            'version_id' => $version_latest['id'],
            'log' => $log,
            'request_id' => $request_id,
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);

        if( !$newId )
        {
            $msg = 'Error: Create Version Failed!';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Create Version Success!');
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
            $this->session->set('flashMsg', 'Invalid Version Note');
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }
        if(is_numeric($ids) && $ids)
        {
            $log = $this->request->post->get('log', '', 'string');

            $try = $this->VersionNoteEntity->update([
                'log' => $log,
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $ids,
            ]);
            
            if($try) 
            {
                $this->session->set('flashMsg', 'Edit Version Successfully');
                $this->app->redirect(
                    $this->router->url('admin/detail-request/'. $request_id)
                );
            }
            else
            {
                $msg = 'Error: Save Version Failed';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('admin/detail-request/'. $request_id)
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
                if( $this->VersionNoteEntity->remove( $id ) )
                {
                    $count++;
                }
            }
        }
        elseif( is_numeric($ids) )
        {
            if( $this->VersionNoteEntity->remove($ids ) )
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
        $this->validateVersion();
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

    public function validateVersion()
    {
        if (!$this->container->exists('VersionEntity'))
        {
            $this->session->set('flashMsg', 'Invalid Plugin Version');
            $this->app->redirect(
                $this->router->url('admin')
            );
        }
    }
}