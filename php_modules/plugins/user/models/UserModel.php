<?php
/**
 * SPT software - Model
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic model
 * 
 */

namespace App\plugins\user\models;

use SPT\JDIContainer\Base; 

class UserModel extends Base 
{ 
    // Write your code here
    public function getRightAccess()
    {
        $access = [];
        foreach($this->plugin as $key => $plugin)
        {
            $right_access = [];
            if (method_exists($this->plugin->$key, 'getRightAccess'))
            {
                $right_access = $this->plugin->$key->getRightAccess();
            }

            if (is_array($right_access) && $right_access)
            {
                $access = array_merge($right_access, $access);
            }
        }

        return $access;
    }

}
