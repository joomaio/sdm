<?php
/**
 * SPT software - Application
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic Application implement mvc
 * 
 */

namespace Tests\simulate; 

use App\libraries\appPlg; 

class appTest extends appPlg
{
    public function redirect($url = null)
    {
        if (!$this->get('url_redirect', ''))
        {
            $this->set('url_redirect', $url);
        }
    }

    public function response($content, $code='200')
    {
        $this->set('respone_content', $content);
        $this->set('respone_code', $code);
    }
}
