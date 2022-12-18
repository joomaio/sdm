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

class DocumentModel extends Base 
{ 
    // Write your code here
    public function remove($id)
    {
        $discussion = $this->DiscussionEntity->list(0, 0, ['document_id = '. $id]);

        $try = $this->DocumentEntity->remove($id);
        if ($try)
        {
            foreach ($discussion as $item)
            {
                $this->DiscussionEntity->remove($item['id']);
            }
        }

        return $try;
    }   
}
