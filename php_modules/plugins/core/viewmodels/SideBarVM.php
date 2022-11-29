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
        $this->set('path_current', $this->router->get('actualPath')); 
        $this->set('logout_link', $this->router->url('admin/logout')); 
        $this->set('link_admin', $this->router->url('admin/')); 
        $this->set('url', $this->router->url(), true);
        $this->set('u_type', $this->user->get('u_type'), true);
    }
}