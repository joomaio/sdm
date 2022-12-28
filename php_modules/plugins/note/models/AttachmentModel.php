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
            if (!file_exists(MEDIA_PATH))
            {
                if (!mkdir(MEDIA_PATH))
                {
                    $this->session->set('flashMsg', 'Upload Fail');
                    return false;
                }
            }
            if (!file_exists(MEDIA_PATH.'attachments'))
            {
                if (!mkdir(MEDIA_PATH.'attachments'))
                {
                    $this->session->set('flashMsg', 'Upload Fail');
                    return false;
                }
            }
            // check extension
            if ($this->config->exists('extension_allow') &&  is_array($this->config->extension_allow))
            {
                $extension = explode('.', $file['name']);
                $extension = end($extension);
                if (!in_array($extension, $this->config->extension_allow))
                {
                    $this->session->set('flashMsg', '.'.$extension.' files are not allowed to upload');
                    return false;
                }
            }
            $uploader = $this->file->setOptions([
                'overwrite' => true,
                'targetDir' => MEDIA_PATH . 'attachments/'
            ]);
    
            // TODO: create dynamice fieldName for file
            $index = 0;
            $tmp_name = $file['name'];
            while(file_exists(MEDIA_PATH. 'attachments/' . $file['name']))
            {
                $file['name'] = $index. "_". $tmp_name;
                $index ++;
            }
            
            if( false === $uploader->upload($file) )
            {
                $this->session->set('flashMsg', 'Invalid attachment');
                return false;
            }
            
            $try = $this->AttachmentEntity->add([
                'note_id' => $note_id,
                'name' => $file['name'],
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
