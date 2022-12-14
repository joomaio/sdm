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
            $this->session->set('flashMsg', "Invalid note");
            return $this->app->redirect(
                $this->router->url('notes')
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
        $description = $this->request->post->get('description', '', 'string');
        $description_sheetjs = $this->request->post->get('description_sheetjs', '', 'string');
        $save_close = $this->request->post->get('save_close', '', 'string');
        $files = $this->request->file->get('files', [], 'array');
        $note = $this->request->post->get('note', '', 'string');
        $editor = $this->request->post->get('editor', 'html', 'string');

        $listTag = explode(',', $tags);
        $tags_tmp = [];
        foreach($listTag as $tag)
        {
            if (!$tag) continue;
            $find = $this->TagEntity->findOne(['id', $tag]);
            if ($find)
            {
                $tags_tmp[] = $tag;
            }
            elseif( !(int) $tag)
            {
                $newTag = $this->TagEntity->add(['name' => $tag]);
                if ($newTag)
                {
                    $tags_tmp[] = $newTag;
                }
            }
        }
        if ($editor == 'sheetjs')
        {
            $description = base64_decode($description_sheetjs);
        }

        if (!$title)
        {
            $this->session->set('flashMsg', 'Error: Title is required! ');
            return $this->app->redirect(
                $this->router->url('note/0')
            );
        }

        $findOne = $this->NoteEntity->findOne(['title = "'. $title. '"']);
        if ($findOne)
        {
            $this->session->set('flashMsg', 'Error: Title already used! ');
            return $this->app->redirect(
                $this->router->url('note/0')
            );
        }

        // TODO: validate new add
        $newId =  $this->NoteEntity->add([
            'title' => $title,
            'tags' => $tags,
            'note' => $note,
            'editor' => $editor,
            'description' => $description,
            'created_by' => $this->user->get('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'modified_by' => $this->user->get('id'),
            'modified_at' => date('Y-m-d H:i:s')
        ]);

        if( !$newId )
        {
            $msg = 'Error: Created Failed!';
            $this->session->set('flashMsg', $msg);
            return $this->app->redirect(
                $this->router->url('note/0')
            );
        }
        else
        {
            if ($files && is_array($files['name']) && $files['name'][0])
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
                        return $this->app->redirect(
                            $this->router->url('note/'. $newId)
                        );
                    }
                }
            }
            $this->session->set('flashMsg', 'Created Successfully!');
            $link = $save_close ? 'notes' : 'note/'. $newId;
            return $this->app->redirect(
                $this->router->url($link)
            );
        }
    }

    public function update()
    {
        $ids = $this->validateID();

        // TODO valid the request input

        if(is_numeric($ids) && $ids)
        {
            $title = $this->request->post->get('title', '', 'string');
            $tags = $this->request->post->get('tags', '', 'string');
            $description = $this->request->post->get('description', '', 'string');
            $description_sheetjs = $this->request->post->get('description_sheetjs', '', 'string');
            $findOne = $this->NoteEntity->findOne(['title = "'. $title. '"', 'id <> '. $ids]);
            $files = $this->request->file->get('files', [], 'array');
            $save_close = $this->request->post->get('save_close', '', 'string');
            $note = $this->request->post->get('note', '', 'string');
            $editor = $this->request->post->get('editor', 'html', 'string');

            $listTag = explode(',', $tags);
            $tags_tmp = [];
            foreach($listTag as $tag)
            {
                if (!$tag) continue;
                $find = $this->TagEntity->findOne(['id', $tag]);
                if ($find)
                {
                    $tags_tmp[] = $tag;
                }
                else
                {
                    $newTag = $this->TagEntity->add(['name' => $tag]);
                    if ($newTag)
                    {
                        $tags_tmp[] = $newTag;
                    }
                }
            }
            $tags = implode(',', $tags_tmp);

            if (!$title)
            {
                $this->session->set('flashMsg', 'Error: Title is required! ');
                return $this->app->redirect(
                    $this->router->url('note/0')
                );
            }

            if ($editor == 'sheetjs')
            {
                $description = base64_decode($description_sheetjs);
            }

            if ($findOne)
            {
                $this->session->set('flashMsg', 'Error: Title already used! ');
                return $this->app->redirect(
                    $this->router->url('note/'. $ids)
                );
            }

            $try = $this->NoteEntity->update([
                'title' => $title,
                'tags' => $tags,
                'note' => $note,
                'editor' => $editor,
                'description' => $description,
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s'),
                'id' => $ids,
            ]);

            if($try)
            {
                if ($files && is_array($files['name']) && $files['name'][0])
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
                            return $this->app->redirect(
                                $this->router->url('note/'. $ids)
                            );
                        }
                    }
                } 
                $this->session->set('flashMsg', 'Updated successfully');
                $link = $save_close ? 'notes' : 'note/'. $ids;
                return $this->app->redirect(
                    $this->router->url($link)
                );
            }
            else
            {
                $msg = 'Error: Updated failed';
                $this->session->set('flashMsg', $msg);
                return $this->app->redirect(
                    $this->router->url('note/'. $ids)
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
        return $this->app->redirect(
            $this->router->url('notes'),
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

            $this->session->set('flashMsg', 'Invalid note');
            return $this->app->redirect(
                $this->router->url('notes'),
            );
        }

        return $id;
    }
}