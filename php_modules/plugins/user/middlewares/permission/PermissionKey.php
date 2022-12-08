<?php
/**
 * SPT software - Application Instance
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Application Instance
 * 
 */

namespace App\plugins\user\middlewares\permission;

use SPT\Middleware\Script;
use SPT\App\Instance as AppIns;

class PermissionKey extends Script
{
    public function allow($params)
    {
        if ( is_array( $params['PermissionKey'] ))
        { 
            $user = AppIns::factory('user');
            $request = AppIns::factory('request');
            $method = $request->header->getRequestMethod();
            $allows = isset($params['PermissionKey'][$method]) && is_array($params['PermissionKey'][$method]) ? $params['PermissionKey'][$method] : $params['PermissionKey'];
            foreach($user->getPermissions($user->get('id')) as $permission)
            {
                if( in_array( $permission, $allows) )
                {
                    return true;
                }
            }
        }

        if (!$this->next) {
            return false;
        }

        return $this->next->allow($params);
    }
}
