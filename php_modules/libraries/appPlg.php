<?php
/**
 * SPT software - Application
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic Application implement mvc
 * 
 */

namespace App\libraries; 

use SPT\App\JDIContainer\CMSApp; 
use SPT\Middleware\Dispatcher as MW;

class appPlg extends CMSApp
{
    public function getName(string $extra='')
    {
        return 'App\\'. $extra;
    }

    public function routing()
    {
        $routing = parent::routing();

        $middleware = $this->get('middleware', []);
        if  (is_array($middleware) && $middleware && isset($middleware['permission']) && is_array($middleware['permission']))
        {
            $permissionList = array_keys($middleware['permission']);
            $permissionParams = $middleware['permission'];
        }
        else
        {
            $permissionList = [];
            $permissionParams = [];
        }

        $try = MW::fire('permission', $permissionList, $permissionParams);

        if (false === $try)
        {
            throw new \Exception('You are not allowed.', 403);
        }

        return $routing;
    }
}
