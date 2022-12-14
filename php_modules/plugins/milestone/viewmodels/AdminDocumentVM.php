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

class AdminDocumentVM extends ViewModel
{
    protected $alias = 'AdminDocumentVM';
    protected $layouts = [
        'layouts.backend.document' => [
            'form'
        ]
    ];

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $request_id = (int) $urlVars['request_id'];

        $editor = $this->request->get->get('editor', '');
        $data = $request_id ? $this->DocumentEntity->findOne(['request_id = '. $request_id ]) : [];
        $data = $data ? $data : ['id' => 0];
        $editor = 1;
        $form = new Form($this->getFormFields(), $data ? $data : []);
        $request = $this->RequestEntity->findByPK($request_id);
        $milestone = $request ? $this->MilestoneEntity->findByPK($request['milestone_id']) : ['title' => '', 'id' => 0];
        $title_page = 'Document';

        $history = $this->DocumentHistoryEntity->list(0,0,['document_id = '.$data['id']]);
        $discussion = $this->DiscussionEntity->list(0, 0, ['document_id = '. $data['id']], 'sent_at asc');
        $discussion = $discussion ? $discussion : [];
        foreach ($discussion as &$item)
        {
            $user_tmp = $this->UserEntity->findByPK($item['user_id']);
            $item['user'] = $user_tmp ? $user_tmp['name'] : '';
        }

        $this->set('form', $form, true);
        $this->set('data', $data, true);
        $this->set('history', $history ? $history : []);
        $this->set('discussion', $discussion ? $discussion : []);
        $this->set('editor', $editor);
        $this->set('user_id', $this->user->get('id'));
        $this->set('title_page_document', $title_page, true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('detail-request/'. $request_id));
        $this->set('link_form', $this->router->url('document/'. $request_id));
        $this->set('link_form_comment', $this->router->url('discussion/'. $request_id));
    }

    public function getFormFields()
    {
        $fields = [
            'id' => ['hidden'],
            'description' => ['tinymce',
                'showLabel' => false,
                'formClass' => 'form-control',
                'rows' => 25,
            ],
            
            'token' => ['hidden',
                'default' => $this->app->getToken(),
            ],
        ];

        return $fields;
    }
}
