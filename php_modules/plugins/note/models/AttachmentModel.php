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
use Google\Client;
use Google\Service\Drive;

class AttachmentModel extends Base
{ 
    // Write your code here
    public function upload($file, $note_id)
    {
        if($file['name']) 
        {
            $type_file = 0; // 0: upload my serve | 1: Upload google drive
            $client_id = $this->OptionModel->get('client_id', '');
            $client_secret = $this->OptionModel->get('client_secret', '');
            $access_token = $this->OptionModel->get('access_token', '');
            $folder_id = $this->OptionModel->get('folder_id', '');

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
                $extension = end(explode('.', $file['name']));
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

            if (!empty($client_id) && !empty($client_secret) && !empty($access_token)){

                $client = new Client();
                $client->setClientId($client_id);
                $client->setAccessToken($access_token);
                $client->setClientSecret($client_secret);

                $client->addScope(Drive::DRIVE);
                $driveService = new Drive($client);
                $fileMetadata = new Drive\DriveFile(array(
                    'name' => time(). '_' .$file['name'],
                    'parents' => [$folder_id]
                ));
                $content = file_get_contents($file['tmp_name']);
                $file_upload = $driveService->files->create($fileMetadata, array(
                    'data' => $content,
                    'mimeType' => $file['type'],
                    'uploadType' => 'multipart',
                    'fields' => 'id'));

                if (empty($file_upload->id)){
                    $this->session->set('flashMsg', 'Invalid config Google Drive');
                    return false;
                }
                $path = 'https://drive.google.com/open?id='.$file_upload->id;
                $file_name = time(). '_' .$file['name'];
                $type_file = 1;

                goto upload;
            }
    
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
            $file_name = $file['name'];
            $path = 'media/attachments/' . $file['name'];

            upload:
            $try = $this->AttachmentEntity->add([
                'note_id' => $note_id,
                'name' => $file_name,
                'path' => $path,
                'type_file' => $type_file,
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
