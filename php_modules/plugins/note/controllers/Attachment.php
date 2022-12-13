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

class Attachment extends Admin {
    public function delete()
    {
        $id = $this->validateID();
        $item = $this->AttachmentEntity->findByPK($id);

        if( $id && $item)
        {
            if( $this->AttachmentModel->remove($id ) )
            {
                $count++;
            }
            else
            {
                $this->app->redirect(
                    $this->router->url('admin/note/'. $item['note_id']),
                );
            }
            $this->session->set('flashMsg', $count.' deleted file(s)');
            $this->app->redirect(
                $this->router->url('admin/note/'. $item['note_id']),
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Invalid Attachment');
            $this->app->redirect(
                $this->router->url('admin/notes'),
            );
        }
    }

    public function validateID()
    {
        $this->isLoggedIn();

        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];

        if(empty($id))
        {
            $this->session->set('flashMsg', 'Invalid Attachment');
            $this->app->redirect(
                $this->router->url('admin/notes'),
            );
        }

        return $id;
    }
}