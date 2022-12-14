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

class AdminVersionLatestVM extends ViewModel
{
    protected $alias = 'AdminVersionLatestVM';
    protected $layouts = [
        'layouts.backend.version_latest' => [
            'list'
        ]
    ];

    public function list()
    {
        $version_latest = $this->VersionEntity->list(0, 1, [], 'created_at desc');
        $version_latest = $version_latest ? $version_latest[0] : [];
        $urlVars = $this->request->get('urlVars');
        $request_id = (int) $urlVars['request_id'];
        $this->set('request_id', $request_id, true);

        if (!$version_latest)
        {
            $version_latest['id'] = 0;
        }
        $list = $this->VersionNoteEntity->list(0,0, ['version_id = '. $version_latest['id'], 'request_id = '. $request_id]);
        $list = $list ? $list : [];
        $request = $this->RequestEntity->findByPK($request_id);
        $milestone = $request ? $this->MilestoneEntity->findByPK($request['milestone_id']) : ['title' => '', 'id' => 0];
        $title_page = 'Version';

        $this->set('list', $list, true);
        $this->set('version_latest', $version_latest);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('request-version/'. $request_id), true);
        $this->set('link_cancel', $this->router->url('detail-request/'. $request_id), true);
        $this->set('title_page_version', $title_page, true);
        $this->set('link_form', $this->router->url('request-version/'. $request_id), true);
        $this->set('token', $this->app->getToken(), true);
    }

}
