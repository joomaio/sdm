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
            'form',
        ],
        'layouts.backend.setting' => [
            'connections',
        ],
    ];

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        $this->set('id', $id, true);

        $data = $id ? $this->NoteEntity->findByPK($id) : [];
        if ($data)
        {
            $data['description_sheetjs'] = base64_encode(strip_tags($data['description']));
        }

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
                'formClass' => 'd-none',
            ],
            'description_sheetjs' => [
                'sheetjs',
                'showLabel' => false,
                'formClass' => 'field-sheetjs',
            ],
            'note' => [
                'textarea',
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

        return $fields;
    }

    public function connections()
    {
        
        $fields = $this->getFormFieldsConnection();
        
        $data = [];
        foreach ($fields as $key => $value) {
            if ($key != 'token') {
                $data[$key] =  $this->OptionModel->get($key, '');
            }
        }
        $form = new Form($fields, $data);

        $title_page = 'Setting Connections';
        $this->view->set('fields', $fields, true);
        $this->view->set('form', $form, true);
        $this->view->set('title_page', $title_page, true);
        $this->view->set('data', $data, true);
        $this->view->set('url', $this->router->url(), true);
        $this->view->set('link_form', $this->router->url('setting-connections'));
    }

    public function getFormFieldsConnection()
    {
        $fields = [
            'folder_id' => [
                'text',
                'label' => 'Folder ID:',
                'formClass' => 'form-control',
            ],
            'client_id' => [
                'text',
                'label' => 'Client ID:',
                'formClass' => 'form-control',
            ],
            'client_secret' => [
                'text',
                'label' => 'Client secret',
                'formClass' => 'form-control',
            ],
            'access_token' => [
                'text',
                'label' => 'Access Token',
                'formClass' => 'form-control',
            ],
            'token' => ['hidden',
                'default' => $this->app->getToken(),
            ],
        ];
       
        return $fields;
    }
}
