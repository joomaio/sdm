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

class Discussion extends Admin 
{
    public function add()
    {
        $this->isLoggedIn();
        $request_id = $this->validateRequestID();
        $document = $this->DocumentEntity->findOne(['request_id = '. $request_id]);
        $message = $this->request->post->get('message', '', 'string');
        if (!$message)
        {
            $this->session->set('flashMsg', 'Message can\'t empty!');
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }

        if ($document)
        {
            $newId = $this->DiscussionEntity->add([
                'user_id' => $this->user->get('id'),
                'document_id' => $document['id'],
                'message' => $message,
                'sent_at' => date('Y-m-d H:i:s'),
                'modified_at' => date('Y-m-d H:i:s'),
            ]);

            $msg = $newId ? 'Comment Success' : 'Comment Fail';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }

        // TODO: validate new add
        $document =  $this->DocumentEntity->add([
            'request_id' => $request_id,
            'description' => '',
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);
        if (!$document)
        {
            $msg = 'Comment Fail';
            $this->session->set('flashMsg', $msg);
            $this->app->redirect(
                $this->router->url('admin/detail-request/'. $request_id)
            );
        }
        
        $newId = $this->DiscussionEntity->add([
            'user_id' => $this->user->get('id'),
            'document_id' => $document,
            'message' => $message,
            'sent_at' => date('Y-m-d H:i:s'),
            'modified_at' => date('Y-m-d H:i:s'),
        ]);

        $msg = $newId ? 'Comment Success' : 'Comment Fail';
        $this->session->set('flashMsg', $msg);
        $this->app->redirect(
            $this->router->url('admin/detail-request/'. $request_id)
        );

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