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
            return $this->app->response([
                'result' => 'fail',
                'message' => 'Message discussion can\'t empty!',
            ], 200);
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

            $msg = $newId ? 'Comment Successfully' : 'Comment Fail';
            return $this->app->response([
                'result' => 'ok',
                'message' => $msg,
            ], 200);
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
            return $this->app->response([
                'result' => 'fail',
                'message' => $msg,
            ], 200);
        }
        
        $newId = $this->DiscussionEntity->add([
            'user_id' => $this->user->get('id'),
            'document_id' => $document,
            'message' => $message,
            'sent_at' => date('Y-m-d H:i:s'),
            'modified_at' => date('Y-m-d H:i:s'),
        ]);

        $msg = $newId ? 'Comment Successfully' : 'Comment Fail';
        return $this->app->response([
            'result' => 'ok',
            'message' => $msg,
        ], 200);

    }

    public function validateRequestID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['request_id'];

        if(empty($id))
        {
            $this->session->set('flashMsg', 'Invalid Request');
            return $this->app->redirect(
                $this->router->url('milestones'),
            );
        }

        return $id;
    }
}