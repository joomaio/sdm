<?php

/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: A simple View Model
 * 
 */

namespace App\plugins\note\viewmodels;

use SPT\View\VM\JDIContainer\ViewModel;
use SPT\View\Gui\Form;

class AdminNoteVM extends ViewModel
{
    protected $alias = 'AdminNoteVM';
    protected $layouts = [
        'layouts.backend.note' => [
            'form'
        ]
    ];

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        $this->set('id', $id, true);

        $data = $id ? $this->NoteEntity->findByPK($id) : [];
        
        $data_tags = [];
        if (!empty($data['tags'])){
            $where[] = "(`id` IN (".$data['tags'].") )";
            $data_tags = $this->TagEntity->list(0, 1000, $where);
        }
        $attachments = $this->AttachmentEntity->list(0, 0, ['note_id = '. $id]);
        $form = new Form($this->getFormFields(), $data);

        $this->set('form', $form, true);
        $this->set('data', $data, true);
        $this->set('data_tags', $data_tags, true);
        $this->set('attachments', $attachments);
        $this->set('title_page_edit', $data ? $data['title'] : 'New Note', true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('notes'));
        $this->set('link_form', $this->router->url('note'));
        $this->set('link_form_attachment', $this->router->url('attachment'));
        $this->set('link_form_download_attachment', $this->router->url('download/attachment'));
        $this->set('link_tag', $this->router->url('tag'));
    }

    public function getFormFields()
    {
        $fields = [
            'description' => [
                'tinymce',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'file' => [
                'file',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'title' => [
                'text',
                'showLabel' => false,
                'placeholder' => 'New Title',
                'formClass' => 'form-control border-0 border-bottom fs-2 py-0',
                'required' => 'required',
            ],
            'tags' => [
                'text',
                'showLabel' => false,
                'placeholder' => 'Tags',
                'formClass' => 'form-control',
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
