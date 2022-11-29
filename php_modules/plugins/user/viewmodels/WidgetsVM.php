<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic viewmodel
 * 
 */
namespace App\plugins\user\viewmodels; 

use SPT\View\VM\JDIContainer\ViewModel; 

class WidgetsVM extends ViewModel
{
    protected $alias = '';
    protected $layouts = [
        'widgets' => [
            'head',
            'topics',
            'header_menu',
        ]
    ];

    public function head()
    {
        $this->set('url', $this->router->url(), true);
    }

    public function topics()
    {
        $topic = $this->TopicEntity->list(0, 0, [], 'topic_name');
        $isLogged = $this->user->get('id') ? true : false;
        $total = $this->TopicEntity->getListTotal();

        $this->set('isLogged', $isLogged);
        $this->set('topic', $topic);
        $this->set('total', $total);
    }

    public function header_menu()
    {
        if (!$this->user->get('u_id')) {
            $uid = 'visitor';
            $u_type = 'other';
            $expire_date = '';
        } else {
            $uid = $this->user->get('userid');
            $u_type = $this->user->get('u_type');
            $expire_date = $this->HelperModel->format_date($this->user->get('expire_date'));
        }
        $this->set('expire_date', $expire_date, true);
        $this->set('uid', $uid, true);
        $this->set('u_type', $u_type, true);
    }
}