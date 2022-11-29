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
use SPT\User\Instance as UserIns;
use App\plugins\facts4me\libraries\User;
use App\plugins\facts4me\entities\UserEntity;

class appPlg extends CMSApp
{
    public function getName(string $extra='')
    {
        return 'App\\'. $extra;
    }

    public function prepareUser()
    {
        $user = new UserIns( new User());
        $user->init([
            'session' => $this->session,
            'entity' => new UserEntity($this->query)
        ]);
        $this->getContainer()->share('user', $user, true);
    }
}
