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

class Note extends Admin 
{
    public function detail()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        
        $request_id = $this->validateRequestID();
        $exist = $this->RelateNoteEntity->findByPK($id);
        if(!empty($id) && !$exist) 
        {
            $this->session->set('flashMsg', "Invalid Relate Note");
            return $this->app->redirect(
                $this->router->url('detail-request/'. $request_id)
            );
        }
        $this->app->set('layout', 'backend.relate_note.form');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    }

    public function list()
    {
        $this->isLoggedIn();
        $urlVars = $this->request->get('urlVars');
        $request_id = (int) $urlVars['request_id'];
        $search = $this->request->post->get('search', '', 'string');

        $list = $this->RelateNoteEntity->list( 0, 0, ['request_id' => $request_id], 0);
        $result = [];
        foreach ($list as &$item)
        {
            $note_tmp = $this->NoteEntity->findByPK($item['note_id']);
            if ($note_tmp)
            {
                $item['title'] = $note_tmp['title'];
                $item['description'] = strip_tags((string) $note_tmp['description']) ;
                $item['tags'] = $note_tmp['tags'] ;
            }

            if (strlen($item['description']) > 100)
            {
                $item['description'] = substr($item['description'], 0, 100) .' ...';
            }

            if (!empty($item['tags'])){
                $t1 = $where = [];
                $where[] = "(`id` IN (".$item['tags'].") )";
                $t2 = $this->TagEntity->list(0, 1000, $where,'','`name`');

                foreach ($t2 as $i) $t1[] = $i['name'];

                $item['tags'] = implode(', ', $t1);
            }

            if ($search)
            {
                if (strpos($item['title'], $search) === false && strpos($item['description'], $search) === false && strpos($item['tags'], $search) === false )
                {
                    continue;
                }
            }
            $result[] = $item;
        }

        return $this->app->response(
            $result, 200);
    }

    public function getNote()
    {
        $this->isLoggedIn();
        $urlVars = $this->request->get('urlVars');
        $request_id = (int) $urlVars['request_id'];

        $relate_note = $this->RelateNoteEntity->list(0, 0, ['request_id = '. $request_id]);
        $where = [];
        if ($relate_note)
        {
            foreach ($relate_note as $note)
            {
                $where[] = 'id <> '. $note['note_id'];
            }
        }
        $notes = $this->NoteEntity->list(0 , 0, $where);
        return $this->app->response(
            $notes, 200);
    }

    public function add()
    {
        $this->isLoggedIn();
        $request_id = $this->validateRequestID();
        //check title sprint
        $title = $this->request->post->get('title', '', 'string');
        $note_id = $this->request->post->get('note_id', 0, 'string');
        $description = $this->request->post->get('description', '', 'string');

        if ($note_id)
        {
            $findOne = $this->RelateNoteEntity->findOne(['note_id = '. $note_id, 'request_id = '. $request_id]);
            if ($findOne)
            {
                return $this->app->response([
                    'result' => 'fail',
                    'message' => 'Error: Duplicate Relate Note',
                ], 200);
            }
        }

        // TODO: validate new add
        $newId =  $this->RelateNoteEntity->add([
            'request_id' => $request_id,
            'title' => $title,
            'note_id' => $note_id,
            'description' => $description,
        ]);

        if( !$newId )
        {
            return $this->app->response([
                'result' => 'fail',
                'message' => 'Error: Create Relate Note Failed!',
            ], 200);
        }
        else
        {
            return $this->app->response([
                'result' => 'ok',
                'message' => 'Create Relate Note Successfully!',
            ], 200);
        }
    }

    public function update()
    {
        $ids = $this->validateID(); 
        $request_id = $this->validateRequestID();
        // TODO valid the request input

        if( is_array($ids) && $ids != null)
        {
            return $this->app->redirect(
                $this->router->url('detail-request/'. $request_id)
            );
        }
        if(is_numeric($ids) && $ids)
        {
            $title = $this->request->post->get('title', '', 'string');
            $note_id = $this->request->post->get('note_id', 0, 'string');
            $description = $this->request->post->get('description', '', 'string');

            if ($note_id)
            {
                $findOne = $this->RelateNoteEntity->findOne(['note_id = '. $note_id, 'request_id = '. $request_id]);
                if ($findOne)
                {
                    $this->session->set('flashMsg', 'Error: Duplicate Relate Note');
                    return $this->app->redirect(
                        $this->router->url('detail-request/'. $request_id),
                    );
                }
            }
            $try = $this->RelateNoteEntity->update([
                'title' => $title,
                'note_id' => $note_id,
                'description' => $description,
                'id' => $ids,
            ]);
            
            if($try) 
            {
                $this->session->set('flashMsg', 'Edit Relate Note Successfully');
                return $this->app->redirect(
                    $this->router->url('detail-request/'. $request_id), 
                );
            }
            else
            {
                $msg = 'Error: Save Relate Note Failed';
                $this->session->set('flashMsg', $msg);
                return $this->app->redirect(
                    $this->router->url('detail-request/'. $request_id .'/'. $ids)
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
                if( $this->RelateNoteEntity->remove( $id ) )
                {
                    $count++;
                }
            }
        }
        elseif( is_numeric($ids) )
        {
            if( $this->RelateNoteEntity->remove($ids ) )
            {
                $count++;
            }
        }  
        
        return $this->app->response([
            'result' => 'ok',
            'message' => $count.' deleted record(s)',
        ], 200);
    }

    public function validateID()
    {
        $this->isLoggedIn();
        $request_id = $this->validateRequestID();
        $urlVars = $this->request->get('urlVars');
        $id = isset($urlVars['id']) ? (int) $urlVars['id'] : 0;

        if(empty($id))
        {
            $ids = $this->request->post->get('ids', [], 'array');
            if(count($ids)) return $ids;

            $this->session->set('flashMsg', 'Invalid Relate Note');
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
                $this->router->url('admin'),
            );
        }

        return $id;
    }
}