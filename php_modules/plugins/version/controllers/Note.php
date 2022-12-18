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

class Note extends Admin 
{
    public function list()
    {
        $this->isLoggedIn();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.version_note.list');
    }

    public function add()
    {
        $this->isLoggedIn();

        //check title sprint
        $version_id = $this->validateVersionID();
        $log = $this->request->post->get('log', '', 'string');

        // TODO: validate new add
        $newId =  $this->VersionNoteEntity->add([
            'version_id' => $version_id,
            'log' => $log,
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
                $this->router->url('version-notes/'. $version_id)
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Create Success!');
            $this->app->redirect(
                $this->router->url('version-notes/'. $version_id)
            );
        }
    }

    public function update()
    {
        $ids = $this->validateID(); 
        $version_id = $this->validateVersionID();
        // TODO valid the request input

        if( is_array($ids) && $ids != null)
        {
            $this->session->set('flashMsg', 'Invalid Version Note');
            $this->app->redirect(
                $this->router->url('version-note/'. $version_id)
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
                $this->session->set('flashMsg', 'Edit Successfully');
                $this->app->redirect(
                    $this->router->url('version-notes/'. $version_id)
                );
            }
            else
            {
                $msg = 'Error: Save Failed';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('version-notes/'. $version_id)
                );
            }
        }
    }

    public function delete()
    {
        $ids = $this->validateID();
        $version_id = $this->validateVersionID();
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
            $this->router->url('version-notes/'. $version_id), 
        );
    }

    public function validateID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        if(empty($id))
        {
            $ids = $this->request->post->get('ids', [], 'array');
            if(count($ids)) return $ids;

            $this->session->set('flashMsg', 'Invalid Version');
            $this->app->redirect(
                $this->router->url('versions'),
            );
        }

        return $id;
    }

    public function validateVersionID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['version_id'];

        if(empty($id))
        {
            $this->session->set('flashMsg', 'Invalid Version');
            $this->app->redirect(
                $this->router->url('versions'),
            );
        }

        return $id;
    }
}