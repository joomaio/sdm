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
                return $this->app->redirect(
                    $this->router->url('note/'. $item['note_id']),
                );
            }
            $this->session->set('flashMsg', $count.' deleted file(s)');
            return $this->app->redirect(
                $this->router->url('note/'. $item['note_id']),
            );
        }
        else
        {
            $this->session->set('flashMsg', 'Invalid Attachment');
            return $this->app->redirect(
                $this->router->url('notes'),
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
            return $this->app->redirect(
                $this->router->url('notes'),
            );
        }

        return $id;
    }

    public function download()
    {
        $id = $this->validateID();
        $item = $this->AttachmentEntity->findByPK($id);

        if ($id && $item)
        {
            $path_file = $item['path'];
            if(file_exists($path_file)) {
                header('Content-Description: File Attachment');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($path_file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($path_file));
                flush(); // Flush system output buffer
                readfile($path_file);
                exit;
            }

            $this->session->set('flashMsg', 'Not Found File Attachment!');
            return $this->app->redirect(
                $this->router->url('note/'. $item['note_id']),
            );
        }

        $this->session->set('flashMsg', 'Invalid Attachment!');
        return $this->app->redirect(
            $this->router->url('notes'),
        );
        
    }
}