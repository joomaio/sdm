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
        $version_latest = $this->VersionEntity->list(0, 1, [], 'created_at desc');
        $version_latest = $version_latest ? $version_latest[0] : [];
        $urlVars = $this->request->get('urlVars');
        $request_id = (int) $urlVars['request_id'];
        $list = $this->VersionNoteEntity->list(0,0, ['version_id = '. $version_latest['id'], 'request_id = '. $request_id]);
        $list = $list ? $list : [];

        return $this->app->response(
            $list, 200);
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
            return $this->app->response([
                'result' => 'fail',
                'message' => 'Error: Invalid Version!'
            ],200);
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
            $msg = 'Error: Create Change log Failed!';
            return $this->app->response([
                'result' => 'fail',
                'message' => $msg
            ],200);
        }
        else
        {
            return $this->app->response([
                'result' => 'ok',
                'message' => 'Create Change log Successfully!'
            ],200);
        }
    }

    public function update()
    {
        $ids = $this->validateID(); 
        $request_id = $this->validateRequestID();
        // TODO valid the request input

        if( is_array($ids) && $ids != null)
        {
            return $this->app->response([
                'result' => 'fail',
                'message' => 'Invalid Version Note'
            ],200);
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
                return $this->app->response([
                    'result' => 'ok',
                    'message' => 'Update Change Log Successfully'
                ],200);
            }
            else
            {
                return $this->app->response([
                    'result' => 'fail',
                    'message' => 'Update Change Log Failed'
                ],200);
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
        
        return $this->app->response([
            'result' => 'ok',
            'message' => $count.' deleted record(s)'
        ],200);
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
            return $this->app->redirect(
                $this->router->url('detail-request/'. $request_id),
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
            return $this->app->redirect(
                $this->router->url('milestones'),
            );
        }

        return $id;
    }

    public function validateVersion()
    {
        if (!$this->container->exists('VersionEntity'))
        {
            $this->session->set('flashMsg', 'Invalid Plugin Version');
            return $this->app->redirect(
                $this->router->url('admin')
            );
        }
    }
}