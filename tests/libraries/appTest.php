<?php
/**
 * SPT software - Application
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic Application implement mvc
 * 
 */

namespace Tests\libraries; 

use App\libraries\appPlg; 
use SPT\Request\Base as Request;
use SPT\Storage\File\ArrayType as FileArray;
use SPT\App\Instance as AppIns;

class appTest extends appPlg
{
    public function execute()
    {
        AppIns::path('app') || die('App did not setup properly');

        try{

            $container = $this->getContainer();
            $container->share( 'app', $this, true);
            
            // create request
            $container->set('request', new Request());

            // create config
            if(AppIns::path('config'))
            {
                $config = new FileArray();
                $config->import(AppIns::path('config'));
                $container->set('config', $config);

                // create query
                if( $config->exists('db') )
                {
                    $this->prepareDB($config);
                }
                
                // create router based config
                $this->prepareRouter($config);
            }

            // create session
            $this->prepareSession();

            $this->prepareUser();

            // prepare Service Provider
            $this->prepareServiceProvider();

        }
        catch (Exception $e) 
        {
            $this->response('Caught \Exception: '.  $e->getMessage(), 500);
        }
        
        return $this;
    }
    
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
