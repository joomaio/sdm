<?php
/**
 * SPT software - Application Instance
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Application Instance
 * 
 */

namespace App\plugins\user\middlewares\validation;

use SPT\Middleware\Script;
use SPT\App\Instance as AppIns;

class ValidateGroup extends Script
{
    public function validate($params)
    {
        $request = AppIns::factory('request');
        $GroupEntity = AppIns::factory('GroupEntity');
        $session = AppIns::factory('session');

        $name = $request->post->get('name', '', 'string');
        $urlVars = $request->get('urlVars');
        $id = (int) $urlVars['id'];

        if(!empty($name)) 
        {
            $find = $GroupEntity->findOne(['name' => $name]);
            if ($find && $find['id'] != $id)
            {
                $session->set('validate', "Error: Group Name already exists");
                return false;
            }
        } 
        else 
        {
            $session->set('validate', "Error: Group name can't empty");
            return false;
        }

        if (!$this->next) {
            return true;
        }

        return $this->next->validate($params);
    }
}