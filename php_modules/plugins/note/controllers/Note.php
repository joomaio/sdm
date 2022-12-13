<?php
/**
 * SPT software - homeController
 *
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 *
 */

namespace App\plugins\note\controllers;

use SPT\MVC\JDIContainer\MVController;

class Note extends Admin {
    public function detail()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        $exist = $this->NoteEntity->findByPK($id);

        if(!empty($id) && !$exist)
        {
            $this->session->set('flashMsg', "Invalid Note");
            $this->app->redirect(
                $this->router->url('admin/notes')
            );
        }
        $this->app->set('layout', 'backend.note.form');
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
    }

    public function list()
    {
        $this->isLoggedIn();
        $this->app->set('page', 'backend');
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.note.list');
    }

    public function add()
    {
        $this->isLoggedIn();

        //check title sprint
        $title = $this->request->post->get('title', '', 'string');
        $tags = $this->request->post->get('tags', '', 'string');
        $html_editor = $this->request->post->get('html_editor', '', 'string');
        $files = $this->request->file->get('files', [], 'array');

        if (!$title)
        {
            $this->session->set('flashMsg', 'Error: Title can\'t empty! ');
            $this->app->redirect(
                $this->router->url('admin/note/0')
            );
        }

        $findOne = $this->NoteEntity->findOne(['title = "'. $title. '"']);
        if ($findOne)
        {
            $this->session->set('flashMsg', 'Error: Title is already in use! ');
            $this->app->redirect(
                $this->router->url('admin/note/0')
            );
        }

        // TODO: validate new add
        $newId =  $this->NoteEntity->add([
            'title' => $title,
            'tags' => $tags,
            'html_editor' => $html_editor,
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
                $this->router->url('admin/note/0')
            );
        }
        else
        {
            if (is_array($files['name']) && $files['name'][0])
            {
                for ($i=0; $i < count($files['name']); $i++) 
                { 
                    $file = [
                        'name' => $files['name'][$i],
                        'full_path' => $files['full_path'][$i],
                        'type' => $files['type'][$i],
                        'tmp_name' => $files['tmp_name'][$i],
                        'error' => $files['error'][$i],
                        'size' => $files['size'][$i],
                    ];

                    $try = $this->AttachmentModel->upload($file, $newId);
                    if (!$try)
                    {
                        $this->app->redirect(
                            $this->router->url('admin/note/'. $newId)
                        );
                    }
                }
            }
            $this->session->set('flashMsg', 'Create Success!');
            $this->app->redirect(
                $this->router->url('admin/note/'. $newId)
            );
        }
    }

    public function update()
    {
        $ids = $this->validateID();

        // TODO valid the request input

        if( is_array($ids) && $ids != null)
        {
            // publishment
            $count = 0;
            $action = $this->request->post->get('status', 0, 'string');

            foreach($ids as $id)
            {
                $toggle = $this->NoteEntity->toggleStatus($id, $action);
                $count++;
            }
            $this->session->set('flashMsg', $count.' changed record(s)');
            $this->app->redirect(
                $this->router->url('admin/notes')
            );
        }
        if(is_numeric($ids) && $ids)
        {
            $title = $this->request->post->get('title', '', 'string');
            $tags = $this->request->post->get('tags', '', 'string');
            $html_editor = $this->request->post->get('html_editor', '', 'string');
            $findOne = $this->NoteEntity->findOne(['title = "'. $title. '"', 'id <> '. $ids]);
            $files = $this->request->file->get('files', [], 'array');

            if ($findOne)
            {
                $this->session->set('flashMsg', 'Error: Title is already in use! ');
                $this->app->redirect(
                    $this->router->url('admin/note/'. $ids)
                );
            }

            $try = $this->NoteEntity->update([
                'title' => $title,
                'tags' => $tags,
                'html_editor' => $html_editor,
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $ids,
            ]);

            if($try)
            {
                if (is_array($files['name']) && $files['name'][0])
                {
                    for ($i=0; $i < count($files['name']); $i++) 
                    { 
                        $file = [
                            'name' => $files['name'][$i],
                            'full_path' => $files['full_path'][$i],
                            'type' => $files['type'][$i],
                            'tmp_name' => $files['tmp_name'][$i],
                            'error' => $files['error'][$i],
                            'size' => $files['size'][$i],
                        ];

                        $try = $this->AttachmentModel->upload($file, $ids);
                        if (!$try)
                        {
                            $this->app->redirect(
                                $this->router->url('admin/note/'. $ids)
                            );
                        }
                    }
                } 
                $this->session->set('flashMsg', 'Edit Successfully');
                $this->app->redirect(
                    $this->router->url('admin/note/'. $ids)
                );
            }
            else
            {
                $msg = 'Error: Save Failed';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('admin/note/'. $ids)
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
                if( $this->NoteEntity->remove( $id ) )
                {
                    $count++;
                }
            }
        }
        elseif( is_numeric($ids) )
        {
            if( $this->NoteEntity->remove($ids ) )
            {
                $count++;
            }
        }


        $this->session->set('flashMsg', $count.' deleted record(s)');
        $this->app->redirect(
            $this->router->url('admin/notes'),
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

            $this->session->set('flashMsg', 'Invalid Note');
            $this->app->redirect(
                $this->router->url('admin/notes'),
            );
        }

        return $id;
    }
}