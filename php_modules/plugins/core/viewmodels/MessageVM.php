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

class MessageVM extends ViewModel
{
    protected $alias = 'MessageVM';
    protected $layouts = ['layouts.message|render'];

    public function render()
    {
        $message = $this->session->get('flashMsg');
        $message = is_array($message) ? implode('<br>', $message) : $message;
        $this->view->set('message', $message);
        $this->session->set('flashMsg', '');
    }
}
