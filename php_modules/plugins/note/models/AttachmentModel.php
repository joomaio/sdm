<?php
/**
 * SPT software - Model
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic model
 * 
 */

namespace App\plugins\note\models;

use SPT\JDIContainer\Base; 

class AttachmentModel extends Base
{ 
    // Write your code here
    public function upload($file, $note_id)
    {
        if($file['name']) 
        {
            $uploader = $this->file->setOptions([
                'overwrite' => true,
                'targetDir' => MEDIA_PATH . 'attachments/'
            ]);
    
            // TODO: create dynamice fieldName for file
            if(file_exists(MEDIA_PATH. 'attachments/' . $file['name'])) {
                $file['name'] = round(microtime(true)).'-'.$file['name'];
            }

            if( false === $uploader->upload($file) )
            {
                $this->session->set('flashMsg', 'Invalid attachment');
                return false;
            }
            
            $try = $this->AttachmentEntity->add([
                'node_id' => $note_id,
                'path' => 'media/attachments/' . $file['name'],
                'uploaded_by' => $this->user->get('id'),
                'uploaded_at' => date('Y-m-d H:i:s'),
            ]);
            
            return $try;
        }

        return false;
    }

    public function remove($id)
    {
        $item = $this->AttachmentEntity->findByPK($id);
        if (!$item)
        {
            $this->session->set('flashMsg', 'Invalid attachment');
            return false;
        }

        if($item['path'] && file_exists(PUBLIC_PATH. $item['path']))
        {
            $try = unlink(PUBLIC_PATH. $item['path']);
            if (!$try)
            {
                $this->session->set('flashMsg', 'Remove attachment fail!');
                return false;
            }
        }

        $try = $this->AttachmentEntity->remove($id);

        return $try;
    }
}
