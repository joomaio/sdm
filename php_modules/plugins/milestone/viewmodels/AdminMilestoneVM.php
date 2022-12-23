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
use SPT\Util;

class AdminMilestoneVM extends ViewModel
{
    protected $alias = 'AdminMilestoneVM';
    protected $layouts = [
        'layouts.backend.milestone' => [
            'form'
        ]
    ];

    public function form()
    {
        $form = new Form($this->getFormFields(), []);

        $this->set('form', $form, true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('milestones'));
        $this->set('link_form', $this->router->url('milestone'));
    }

    public function getFormFields()
    {
        $fields = [
            'id' => ['hidden'],
            'title' => [
                'text',
                'placeholder' => 'New Milestone',
                'showLabel' => false,
                'formClass' => 'form-control h-50-px fw-bold rounded-0 fs-3',
                'required' => 'required',
            ],
            'description' => ['textarea',
                'placeholder' => 'Enter Description',
                'showLabel' => false,
                'formClass' => 'form-control rounded-0 border border-1 py-1 fs-4-5',
            ],
            'start_date' => ['date',
                'showLabel' => false,
                'formClass' => 'form-control rounded-0 border border-1 py-1 fs-4-5',
            ],
            'end_date' => ['date',
                'showLabel' => false,
                'formClass' => 'form-control rounded-0 border border-1 py-1 fs-4-5',
            ],
            'status' => ['option',
                'showLabel' => false,
                'type' => 'radio_inline',
                'formClass' => 'd-flex',
                'default' => 1,
                'options' => [
                    ['text'=>'Show', 'value'=>1],
                    ['text'=>'Hide', 'value'=>0]
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
