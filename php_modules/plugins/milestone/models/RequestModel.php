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
        $relate_notes = $this->Relate->list(0, 0, ['request_id = '. $id]);
        $try = $this->RequestEntity->remove($id);
        if ($try)
        {
            foreach ($requests as $request)
            {
                $this->RequestModel->remove($id);
            }
        }

        return $try;
    }   
}
