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

class Milestone extends Admin
{
    public function detail()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        $exist = $this->MilestoneEntity->findByPK($id);
        if (!empty($id) && !$exist) {
            $this->session->set('flashMsg', "Invalid Milestone");
            $this->app->redirect(
                $this->router->url('milestones')
            );
        }

        $this->app->set('layout', 'backend.milestone.form');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    }

    public function list()
    {
        $this->isLoggedIn();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.milestone.list');
    }

    public function add()
    {
        $this->isLoggedIn();

        //check title sprint
        $title = $this->request->post->get('title', '', 'string');
        $description = $this->request->post->get('description', '', 'string');
        $start_date = $this->request->post->get('start_date', '', 'string');
        $end_date = $this->request->post->get('end_date', '', 'string');

        if ($start_date == '')
            $start_date = NULL;
        if ($end_date == '')
            $end_date = NULL;

        if (!$title) {
            $this->session->set('flashMsg', 'Error: Title can\'t empty! ');
            $this->app->redirect(
                $this->router->url('milestones')
            );
        }

        $findOne = $this->MilestoneEntity->findOne(['title = "' . $title . '"']);
        if ($findOne) {
            $this->session->set('flashMsg', 'Error: Title is already in use! ');
            $this->app->redirect(
                $this->router->url('milestones')
            );
        }
        // TODO: validate new add
        $newId =  $this->MilestoneEntity->add([
            'title' => $title,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $this->request->post->get('status', ''),
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);

        if (!$newId) {
            $msg = 'Error: Create Failed!';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('milestones')
            );
        } else {
            $this->session->set('flashMsg', 'Create Success!');
            $this->app->redirect(
                $this->router->url('milestones')
            );
        }
    }

    public function update()
    {

        $ids = $this->validateID();

        // TODO valid the request input

        if (is_array($ids) && $ids != null) {
            // publishment
            $count = 0;
            $action = $this->request->post->get('status', 0, 'string');

            foreach ($ids as $id) {
                $toggle = $this->MilestoneEntity->toggleStatus($id, $action);
                $count++;
            }
            $this->session->set('flashMsg', $count . ' changed record(s)');
            $this->app->redirect(
                $this->router->url('milestones')
            );
        }
        if (is_numeric($ids) && $ids) {
            $title = $this->request->post->get('title', '', 'string');
            $description = $this->request->post->get('description', '', 'string');
            $start_date = $this->request->post->get('start_date', '', 'string');
            $end_date = $this->request->post->get('end_date', '', 'string');

            if ($start_date == '')
                $start_date = NULL;
            if ($end_date == '')
                $end_date = NULL;
                
            $findOne = $this->MilestoneEntity->findOne(['title = "' . $title . '"', 'id <> ' . $ids]);
            if ($findOne) {
                $this->session->set('flashMsg', 'Error: Title is already in use! ');
                $this->app->redirect(
                    $this->router->url('milestone/' . $ids)
                );
            }

            $try = $this->MilestoneEntity->update([
                'title' => $title,
                'description' => $description,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $this->request->post->get('status', ''),
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $ids,
            ]);
            if ($try) {
                $this->session->set('flashMsg', 'Edit Successfully');
                $this->app->redirect(
                    $this->router->url('milestones')
                );
            } else {
                $msg = 'Error: Save Failed';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('milestone/' . $ids)
                );
            }
        }
    }

    public function delete()
    {
        $ids = $this->validateID();

        $count = 0;
        if (is_array($ids)) {
            foreach ($ids as $id) {
                //Delete file in source
                if ($this->MilestoneModel->remove($id)) {
                    $count++;
                }
            }
        } elseif (is_numeric($ids)) {
            if ($this->MilestoneModel->remove($ids)) {
                $count++;
            }
        }


        $this->session->set('flashMsg', $count . ' deleted record(s)');
        $this->app->redirect(
            $this->router->url('milestones'),
        );
    }

    public function validateID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        if (empty($id)) {
            $ids = $this->request->post->get('ids', [], 'array');
            if (count($ids)) return $ids;

            $this->session->set('flashMsg', 'Invalid Milestone');
            $this->app->redirect(
                $this->router->url('milestones'),
            );
        }

        return $id;
    }
}
