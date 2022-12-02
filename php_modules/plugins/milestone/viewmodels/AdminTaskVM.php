<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic viewmodel
 * 
 */
namespace App\plugins\milestone\viewmodels; 

use SPT\View\Gui\Form;
use SPT\View\Gui\Listing;
use SPT\View\VM\JDIContainer\ViewModel;

class AdminTaskVM extends ViewModel
{
    protected $alias = 'AdminTaskVM';
    protected $layouts = [
        'layouts.backend.task' => [
            'form'
        ]
    ];

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        $request_id = (int) $urlVars['request_id'];
        $this->set('id', $id, true);

        $data = $id ? $this->TaskEntity->findOne(['id = '. $id, 'request_id = '. $request_id ]) : [];
        
        $form = new Form($this->getFormFields(), $data);
        $request = $this->RequestEntity->findByPK($request_id);
        $milestone = $request ? $this->MilestoneEntity->findByPK($request['milestone_id']) : ['title' => '', 'id' => 0];
        $title_page = $request ? '<a href="'. $this->router->url('admin/requests/'. $milestone['id']).'" >'.$milestone['title'] .'</a> >> Request: '. $request['title'] .' - Task' : 'Task';

        $this->set('form', $form, true);
        $this->set('data', $data, true);
        $this->set('title_page', $title_page, true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('admin/tasks/'. $request_id));
        $this->set('link_form', $this->router->url('admin/task/'. $request_id));
    }

    public function getFormFields()
    {
        $fields = [
            'id' => ['hidden'],
            'title' => [
                'text',
                'placeholder' => 'Enter Title',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required'
            ],
            'url' => ['text',
                'placeholder' => 'Enter Url',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required',
            ],
            'token' => ['hidden',
                'default' => $this->app->getToken(),
            ],
        ];

        return $fields;
    }
}
