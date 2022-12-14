<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic viewmodel
 * 
 */
namespace App\plugins\version\viewmodels; 

use SPT\View\Gui\Form;
use SPT\View\Gui\Listing;
use SPT\View\VM\JDIContainer\ViewModel;
use SPT\Util;

class AdminVersionNotesVM extends ViewModel
{
    protected $alias = 'AdminVersionNotesVM';
    protected $layouts = [
        'layouts.backend.version_note' => [
            'list',
        ]
    ];

    public function list()
    {
        $urlVars = $this->request->get('urlVars');
        $version_id = (int) $urlVars['version_id'];
        $this->set('version_id', $version_id, true);

        $where = ['version_id = '. $version_id];
        $list = $this->VersionNoteEntity->list(0, 0, $where);

        $this->set('list', $list, true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('version-notes/'. $version_id), true);
        $this->set('link_cancel', $this->router->url('versions'), true);
        $this->set('title_page', 'Version Change Log', true);
        $this->set('link_form', $this->router->url('version-note/'. $version_id), true);
        $this->set('token', $this->app->getToken(), true);
    }
}
