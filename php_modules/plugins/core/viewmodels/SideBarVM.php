<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: A simple View Model
 * 
 */

namespace App\plugins\core\viewmodels; 

use SPT\View\VM\JDIContainer\ViewModel; 

class SideBarVM extends ViewModel
{
    protected $alias = 'SideBarVM';
    protected $layouts = [
        'widgets.backend.sidebar'
    ];

    public function sidebar()
    {
        $menu = [];
        foreach ($this->plugin as $plg_name => $plg)
        {
            if (method_exists($plg, 'registerMenu'))
            {
                $menu_tmp = $plg->registerMenu();
                $type = $this->app->get('menu_type', '');
                if ($type == $plg_name)
                {
                    $menu = $menu_tmp;
                    break;
                }

                if (is_array($menu_tmp))
                {
                    $menu = array_merge($menu, $menu_tmp);
                }
            }
        }

        $this->set('path_current', $this->router->get('actualPath')); 
        $this->set('logout_link', $this->router->url('logout')); 
        $this->set('link_admin', $this->router->url('')); 
        $this->set('url', $this->router->url(), true);
        $this->set('menu', $menu);
        $this->set('u_type', $this->user->get('u_type'), true);
    }
}