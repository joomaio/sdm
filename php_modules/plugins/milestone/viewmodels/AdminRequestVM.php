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

class AdminRequestVM extends ViewModel
{
    protected $alias = 'AdminRequestVM';
    protected $layouts = [
        'layouts.backend.request' => [
            'form'
        ]
    ];

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        $milestone_id = (int) $urlVars['milestone_id'];
        $this->set('id', $id, true);

        $data = $id ? $this->RequestEntity->findOne(['id = '. $id, 'milestone_id = '. $milestone_id ]) : [];
        
        $form = new Form($this->getFormFields(), $data);
        $milestone = $this->MilestoneEntity->findOne(['id = '. $milestone_id]);
        $title_page = $milestone ? $milestone['title'] .' - ' : '';
        $this->set('form', $form, true);
        $this->set('data', $data, true);
        $this->set('title_page', $data ? $title_page. 'Edit Request' : $title_page. 'New Request', true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('admin/requests/'. $milestone_id));
        $this->set('link_form', $this->router->url('admin/request/'. $milestone_id));
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
            'note' => ['textarea',
                'placeholder' => 'Enter Note',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required',
            ],
            'status' => ['option',
                'showLabel' => false,
                'type' => 'radio',
                'formClass' => '',
                'default' => 1,
                'options' => [
                    ['text'=>'Active', 'value'=>1],
                    ['text'=>'Inactive', 'value'=>0]
                ]
            ],
            'token' => ['hidden',
                'default' => $this->app->getToken(),
            ],
        ];

        if($this->view->id)
        {
            $fields['modified_at'] = ['readonly'];
            $fields['modified_by'] = ['readonly'];
            $fields['created_at'] = ['readonly'];
            $fields['created_by'] = ['readonly'];
        }
        else
        {
            $fields['modified_at'] = ['hidden'];
            $fields['modified_by'] = ['hidden'];
            $fields['created_at'] = ['hidden'];
            $fields['created_by'] = ['hidden'];
        }

        return $fields;
    }
}