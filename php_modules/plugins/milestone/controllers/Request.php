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

class Request extends Admin 
{
    public function detail()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        
        $milestone_id = $this->validateMilestoneID();
        $exist = $this->RequestEntity->findByPK($id);
        if(!empty($id) && !$exist) 
        {
            $this->session->set('flashMsg', "Invalid Request");
            return $this->app->redirect(
                $this->router->url('requests/'. $milestone_id)
            );
        }
        $this->app->set('layout', 'backend.request.form');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    }

    public function detail_request()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['request_id'];
        
        $exist = $this->RequestEntity->findByPK($id);

        if(!empty($id) && !$exist) 
        {   
            $this->session->set('flashMsg', "Invalid Request");
            return $this->app->redirect(
                $this->router->url('milestones/')
            );
        }

        $this->app->set('layout', 'backend.request.detail_request');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    }

    public function list()
    {
        $this->isLoggedIn();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.request.list');
    }

    public function add()
    {
        $this->isLoggedIn();
        $milestone_id = $this->validateMilestoneID();
        $exist = $this->MilestoneEntity->findByPK($milestone_id);

        $title = $this->request->post->get('title', '', 'string');
        $description = $this->request->post->get('description', '', 'string');
        if (!$title)
        {
            $this->session->set('flashMsg', 'Error: Title can\'t empty! ');
            return $this->app->redirect(
                $this->router->url('requests/'. $milestone_id)
            );
        }
        if(!$exist) {
            $this->session->set('flashMsg', 'Invalid Milestone');
            return $this->app->redirect(
                $this->router->url('milestones')
            );
        }
        // TODO: validate new add
        $newId =  $this->RequestEntity->add([
            'milestone_id' => $milestone_id,
            'title' => $title,
            'description' => $description,
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);

        if( !$newId )
        {
            $msg = 'Error: Create Failed!';
            $this->session->set('flashMsg', $msg);
            return $this->app->redirect(
                $this->router->url('requests/'. $milestone_id)
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Create Successfully!');
            return $this->app->redirect(
                $this->router->url('requests/'. $milestone_id)
            );
        }
    }

    public function update()
    {
        $ids = $this->validateID(); 
        $milestone_id = $this->validateMilestoneID();
        // TODO valid the request input
        $detail_request =  $this->request->post->get('detail_request', '', 'string');
        if(is_numeric($ids) && $ids)
        {
            $title = $this->request->post->get('title', '', 'string');
            $description = $this->request->post->get('description', '', 'string');
 
            $try = $this->RequestEntity->update([
                'milestone_id' => $milestone_id,
                'title' => $title,
                'description' => $description,
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $ids,
            ]);
            
            if($try) 
            {
                $this->session->set('flashMsg', 'Edit Successfully');
                $link = $detail_request ? 'detail-request/'. $ids : 'requests/'. $milestone_id;
                return $this->app->redirect(
                    $this->router->url($link)
                );
            }
            else
            {
                $msg = 'Error: Save Failed';
                $this->session->set('flashMsg', $msg);
                return $this->app->redirect(
                    $this->router->url('requests/'. $milestone_id .'/'. $ids)
                );
            }
        }
    }

    public function delete()
    {
        $ids = $this->validateID();
        $milestone_id = $this->validateMilestoneID();
        $count = 0;
        if( is_array($ids))
        {
            foreach($ids as $id)
            {
                //Delete file in source
                if( $this->RequestEntity->remove( $id ) )
                {
                    $count++;
                }
            }
        }
        elseif( is_numeric($ids) )
        {
            if( $this->RequestEntity->remove($ids ) )
            {
                $count++;
            }
        }  
        

        $this->session->set('flashMsg', $count.' deleted record(s)');
        return $this->app->redirect(
            $this->router->url('requests/'. $milestone_id), 
        );
    }

    public function validateID()
    {
        $this->isLoggedIn();
        $milestone_id = $this->validateMilestoneID();
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        if(empty($id))
        {
            $ids = $this->request->post->get('ids', [], 'array');
            if(count($ids)) return $ids;

            $this->session->set('flashMsg', 'Invalid request');
            return $this->app->redirect(
                $this->router->url('requests/'. $milestone_id),
            );
        }

        return $id;
    }

    public function validateMilestoneID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');

        $id = (int) $urlVars['milestone_id'];
        if(empty($id))
        {
            $this->session->set('flashMsg', 'Invalid Milestone');
            return $this->app->redirect(
                $this->router->url('milestones'),
            );
        }

        return $id;
    }
}