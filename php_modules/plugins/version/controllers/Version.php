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

class Version extends Admin 
{
    public function detail()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        $exist = $this->VersionEntity->findByPK($id);
        if(!empty($id) && !$exist) 
        {
            $this->session->set('flashMsg', "Invalid Version");
            $this->app->redirect(
                $this->router->url('admin/versions')
            );
        }
        $this->app->set('layout', 'backend.version.form');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    }

    public function list()
    {
        $this->isLoggedIn();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.version.list');
    }

    public function add()
    {
        $this->isLoggedIn();

        //check title sprint
        $name = $this->request->post->get('name', '', 'string');
        $release_date = $this->request->post->get('release_date', '', 'string');
        $note = $this->request->post->get('note', '', 'string');
        if (!$name)
        {
            $this->session->set('flashMsg', 'Error: Name can\'t empty! ');
            $this->app->redirect(
                $this->router->url('admin/versions')
            );
        }

        $findOne = $this->VersionEntity->findOne(['name = "'. $name. '"']);
        if ($findOne)
        {
            $this->session->set('flashMsg', 'Error: Version name is already in use! ');
            $this->app->redirect(
                $this->router->url('admin/versions')
            );
        }
        // TODO: validate new add
        $newId =  $this->VersionEntity->add([
            'name' => $name,
            'release_date' => $release_date,
            'note' => $note,
            'status' => $this->request->post->get('status', 1, 'string'),
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
                $this->router->url('admin/versions')
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Create Success!');
            $this->app->redirect(
                $this->router->url('admin/versions')
            );
        }
    }

    public function update()
    {
        $ids = $this->validateID(); 
       
        // TODO valid the request input

        if( is_array($ids) && $ids != null)
        {
            $this->session->set('flashMsg', 'Invalid Version');
            $this->app->redirect(
                $this->router->url('admin/versions')
            );
        }
        if(is_numeric($ids) && $ids)
        {
            $name = $this->request->post->get('name', '', '');
            $release_date = $this->request->post->get('release_date', '', '');
            $note = $this->request->post->get('note', '', '');
            $findOne = $this->VersionEntity->findOne(['name = "'. $name. '"', 'id <> '. $ids]);
            if ($findOne)
            {
                $this->session->set('flashMsg', 'Error: Version name is already in use! ');
                $this->app->redirect(
                    $this->router->url('admin/versions')
                );
            }

            $try = $this->VersionEntity->update([
                'name' => $name,
                'release_date' => $release_date,
                'note' => $note,
                'status' => $this->request->post->get('status', 0, 'string'),
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $ids,
            ]);
            
            if($try) 
            {
                $this->session->set('flashMsg', 'Edit Successfully');
                $this->app->redirect(
                    $this->router->url('admin/versions')
                );
            }
            else
            {
                $msg = 'Error: Save Failed';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('admin/versions')
                );
            }
        }
    }

    public function delete()
    {
        $ids = $this->validateID();
        
        $count = 0;
        if( is_array($ids))
        {
            foreach($ids as $id)
            {
                //Delete file in source
                if( $this->VersionEntity->remove( $id ) )
                {
                    $count++;
                }
            }
        }
        elseif( is_numeric($ids) )
        {
            if( $this->VersionEntity->remove($ids ) )
            {
                $count++;
            }
        }  
        

        $this->session->set('flashMsg', $count.' deleted record(s)');
        $this->app->redirect(
            $this->router->url('admin/versions'), 
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
                $this->router->url('admin/versions'),
            );
        }

        return $id;
    }

}