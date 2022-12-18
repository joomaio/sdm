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

class AdminRelateNoteVM extends ViewModel
{
    protected $alias = 'AdminRelateNoteVM';
    protected $layouts = [
        'layouts.backend.relate_note' => [
            'form'
        ]
    ];

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $request_id = (int) $urlVars['request_id'];

        $form = new Form($this->getFormFields(), []);

        $this->set('form', $form, true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('relate-notes/'. $request_id));
        $this->set('link_form', $this->router->url('relate-note/'. $request_id));
    }

    public function getFormFields()
    {
        $notes = [];
        if ($this->container->exists('NoteEntity'))
        {
            $urlVars = $this->request->get('urlVars');
            $id = (int) $urlVars['request_id'];
            $where = [];
            if ($id)
            {
                $relate_note = $this->RelateNoteEntity->list(0, 0, ['request_id = '. $id]);
                if ($relate_note)
                {
                    foreach ($relate_note as $note)
                    {
                        $where[] = 'id <> '. $note['note_id'];
                    }
                }
            }
            $notes = $this->NoteEntity->list(0 , 0, $where);
        }
        $options = [[
            'text' => 'Select Note',
            'value' => '',
        ]];
        foreach ($notes as $note)
        {
            $options[] = [
                'text' => $note['title'],
                'value' => $note['id'],
            ];
        }

        $fields = [
            'id' => ['hidden'],
            'title' => [
                'text',
                'placeholder' => 'New Relate Note',
                'showLabel' => false,
                'formClass' => 'form-control h-50-px fw-bold rounded-0 fs-3',
                'required' => 'required'
            ],
            'description' => ['textarea',
                'placeholder' => 'Enter Note',
                'showLabel' => false,
                'formClass' => 'form-control rounded-0 border border-1 py-1 fs-4-5',
                'required' => 'required',
            ],
            'note_id' => ['option',
                'options' => $options,
                'showLabel' => false,
                'formClass' => 'form-select rounded-0 border border-1 py-1 fs-4-5',
                'required' => 'required',
            ],
            'token' => ['hidden',
                'default' => $this->app->getToken(),
            ],
        ];

        return $fields;
    }
}
