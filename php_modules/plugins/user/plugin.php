<?php
/**
 * SPT software - Stater plugin
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic plugin
 * 
 */

namespace App\plugins\user;

use SPT\App\Instance as AppIns;
use SPT\Plugin\CMS as PluginAbstract;
use SPT\Support\Loader;
use Joomla\DI\Container;
use SPT\Middleware\Dispatcher as MW;
use App\plugins\user\middlewares\Permission;
use App\plugins\user\middlewares\Validation;
use SPT\File;
use SPT\Dispatcher;

class plugin extends PluginAbstract
{ 
    public function register()
    {
        Dispatcher::register('afterNewUser', 'UserGroupModel', 'addUserMap');
        Dispatcher::register('afterUpdateUser', 'UserGroupModel', 'updateUserMap');
        Dispatcher::register('afterRemoveUser', 'UserGroupModel', 'removeByUser');
        Dispatcher::register('afterRemoveGroup', 'UserGroupModel', 'removeByGroup');

        $Validation = new Validation('plugins\user\middlewares\validation');
        MW::register('validation', $Validation);

        $permissionList = new Permission('plugins\user\middlewares\permission');
        MW::register('permission', $permissionList);

        return [
            // write your code here
            'viewmodels' => [
                'alias' => [
                    'App\plugins\user\viewmodels\AdminUsersVM' => 'AdminUsersVM',
                    'App\plugins\user\viewmodels\AdminUserVM' => 'AdminUserVM',
                    'App\plugins\user\viewmodels\AdminGroupsVM' => 'AdminGroupsVM',
                    'App\plugins\user\viewmodels\AdminGroupVM' => 'AdminGroupVM',
                ],
            ],
            'models' => [
                'alias' => [
                    'App\plugins\user\models\UserModel' => 'UserModel',
                    'App\plugins\user\models\UserGroupModel' => 'UserGroupModel',
                ],
            ],
            'entity' => [],
            'file' => [],
        ];
    }

    public function getInfo()
    {
        return [
            'name' => 'user',
            'author' => 'Pham Minh',
            'version' =>  '0.1',
            'description' => 'User Plugin'
        ];
    }

    public function loadFile(Container $container)
    {
        $container->set('file', new File());
    }

    public function loadEntity(Container $container)
    {
        $path = AppIns::path('plugin'). 'user/entities';
        $namespace = 'App\plugins\user\entities';
        $inners = Loader::findClass($path, $namespace);
        foreach($inners as $class)
        {
            if(class_exists($class))
            {
                $entity = new $class($container->get('query'));
                $entity->checkAvailability();
                $container->share( $class, $entity, true);
                $alias = explode('\\', $class);
                $container->alias( $alias[count($alias) - 1], $class);
            }
            // else { debug this }
        }
    }

    public function registerMenu()
    {
        return [
            [['users', 'user',], 'users', 'Users', '<i class="fa-solid fa-user"></i>', '', ''],
            [['user-groups', 'user-group',], 'user-groups', 'Groups', '<i class="fa-solid fa-user-group"></i>', '', ''],
            [['logout'], 'logout', 'Logout', '<i class="fa-solid fa-right-from-bracket"></i>', '', '']
        ];
    }

    public function getRightAccess()
    {
        return ['user_manager', 'user_create', 'user_read', 'user_delete', 'user_update', 'usergroup_manager', 'usergroup_read', 'usergroup_create', 'usergroup_update', 'usergroup_delete'];
    }

}
