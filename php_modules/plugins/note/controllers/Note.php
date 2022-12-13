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
        $change_file = $this->request->post->get('change_file', '', 'string');
        $tags = $this->request->post->get('tags', '', 'string');
        $html_editor = base64_encode($_POST['html_editor']);
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

        $url_file = '';
        if (!empty($_FILES['file']['tmp_name']) && $change_file == 1){
            $file = $_FILES['file'];
            if ($file['size'] > 500000){
                $msg = 'File is too large';
                $this->session->set('flashMsg', $msg);
                $this->app->redirect(
                    $this->router->url('admin/note/0')
                );
            }

            $target_dir = $this->file->targetDir.'/';
            $target_file = $target_dir . time() .basename($file['name']);
            $url_file = $this->router->url('upload/').basename($file['name']);
            $upload = move_uploaded_file($file['tmp_name'], $target_file);
            if (!$upload){
                $this->session->set('flashMsg', 'Upload file fail! ');
                $this->app->redirect(
                    $this->router->url('admin/note/0')
                );
            }
        }

        // TODO: validate new add
        $newId =  $this->NoteEntity->add([
            'title' => $title,
            'tags' => $tags,
            'file' => $url_file,
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
            $this->session->set('flashMsg', 'Create Success!');
            $this->app->redirect(
                $this->router->url('admin/notes')
            );
        }
    }

    public function update()
    {
        $ids = $this->validateID();
        $try = false;
        $msg = 'Fail';
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
            $title = $this->request->post->get('title', '');
            $change_file = $this->request->post->get('change_file', 'string');
            $tags = $this->request->post->get('tags', '', 'string');
            $html_editor = base64_encode($_POST['html_editor']);

            $findOne = $this->NoteEntity->findOne(['title = "'. $title. '"', 'id <> '. $ids]);
            if ($findOne)
            {
                $msg = 'Error: Title is already in use! ';
                goto response;
            }

            $value_update = [
                'title' => $title,
                'tags' => $tags,
                'html_editor' => $html_editor,
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $ids,
            ];

            //Handle upload file
            if (!empty($_FILES['file']['tmp_name']) && $change_file == 1){
                $file = $_FILES['file'];

                if ($file['type'] != 'text/html'){
                    $msg = 'Please upload file .html';
                    goto response;
                }
                if ($file['size'] > 500000){
                    $msg = 'File is too large';
                    goto response;
                }

                $target_dir = $this->file->targetDir.'/';
                $file_name = time() . '_' . basename($file['name']);
                $target_file = $target_dir . $file_name;
                $url_file = $this->router->url('upload/').$file_name;
                $upload = move_uploaded_file($file['tmp_name'], $target_file);
                if (!$upload){
                    $msg = 'Upload file fail!';
                    goto response;
                }

                $value_update['file'] = $url_file;
            }


            $try = $this->NoteEntity->update($value_update);

            response:
            if($try)
            {
                $this->session->set('flashMsg', 'Edit Successfully');
                $this->app->redirect(
                    $this->router->url('admin/notes')
                );
            }
            else
            {
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