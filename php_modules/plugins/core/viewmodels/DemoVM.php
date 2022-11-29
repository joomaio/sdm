<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic viewmodel
 * 
 */
namespace App\plugins\core\viewmodels; 

use SPT\View\VM\JDIContainer\ViewModel; 

class DemoVM extends ViewModel
{
    protected $alias = 'DemoVM';
    protected $layouts = ['layouts.demo'];

    public function demo()
    {
        $this->set('url', $this->router->url(), true);
        $this->session->set('flashMsg', '');
    }
}
