<?php
/**
 * SPT software - Model
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic model
 * 
 */

namespace App\plugins\milestone\models;

use SPT\JDIContainer\Base; 

class RequestModel extends Base 
{ 
    // Write your code here
    public function remove($id)
    {
        $tasks = $this->TaskEntity->list(0, 0, ['request_id = '. $id]);
        $relate_notes = $this->RelateNoteEntity->list(0, 0, ['request_id = '. $id]);
        $document = $this->DocumentEntity->list(0, 0, ['request_id = '. $id]);
        $version_notes = [];
        if (!$this->container->exists('VersionEntity'))
        {
            $version_notes = $this->VersionNoteEntity->list(0, 0, ['request_id = '. $id]);
        }
        $try = $this->RequestEntity->remove($id);
        if ($try)
        {
            foreach ($tasks as $task)
            {
                $this->TaskEntity->remove($task['id']);
            }

            foreach ($relate_notes as $note)
            {
                $this->RelateNoteEntity->remove($note['id']);
            }

            foreach ($version_notes as $note)
            {
                $this->VersionNoteEntity->remove($note['id']);
            }

            foreach ($document as $item)
            {
                $this->DocumentModel->remove($item['id']);
            }
        }

        return $try;
    }   
}
