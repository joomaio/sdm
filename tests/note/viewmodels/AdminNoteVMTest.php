<?php
namespace Tests\note\controllers;

use PHPUnit\Framework\TestCase;

use SPT\Query;
use SPT\Router;
use SPT\Extend\Pdo as PdoWrapper;
use Joomla\DI\Container;
use SPT\Session\DatabaseSession;
use SPT\Session\DatabaseSessionEntity;
use SPT\Session\Instance as Session; 
use SPT\Storage\File\ArrayType as FileArray;
use SPT\User\Instance as User;
use SPT\User\SPT\User as UserAdapter;
use SPT\Request\Base as Request;
use SPT\User\SPT\UserEntity;
use SPT\View\VM\View as View; 
use SPT\View\Gui\Form;

use App\plugins\note\entities\AttachmentEntity;
use App\plugins\note\entities\NoteEntity;
use App\plugins\note\entities\TagEntity;
use App\plugins\note\models\AttachmentModel;
use App\plugins\note\controllers\Attachment;
use App\plugins\note\viewmodels\AdminNoteVM;

use Tests\simulate\File;
use Tests\simulate\appTest;

class AdminNoteVMTest extends TestCase
{
    static $session_id;
    static $newID;
    static $removeID;
    static $file;

    protected function setUp(): void
    {
        // Simulate app
        $this->container = new Container();
        $this->app = new appTest($this->container);
        $this->container->set('app', $this->app);

        // Simulate router
        $_SERVER['HTTP_HOST'] = SITE_HOST; 
        $_SERVER['REQUEST_URI'] = SITE_URL; 
        $router = new Router();
        $this->container->set('router', $router);

        // Simulate config
        $config = new FileArray();
        $config_content = (array) require (PATH_CONFIG);
        foreach ($config_content as $key => $value)
        {
            $config->$key = $value;
        }
        $this->container->set('config', $config);

        // Simulate query
        $query = new Query(
            new PdoWrapper(
                $config->db
            ), ['#__' => $config->db['prefix']]
        );
        $this->container->set('query', $query);

        //Simulate Entity
        $this->NoteEntity = new NoteEntity($query);
        $this->AttachmentEntity = new AttachmentEntity($query);
        $this->TagEntity = new TagEntity($query);
        $this->container->set('NoteEntity', $this->NoteEntity); 
        $this->container->set('TagEntity', $this->TagEntity); 
        $this->container->set('AttachmentEntity', $this->AttachmentEntity); 

        // Simulate File
        $this->container->set('file', new File()); 

        // Simulate session
        if (!static::$session_id)
        {
            static::$session_id = rand();
        } 
        $this->session = new Session( new DatabaseSession( new DatabaseSessionEntity($query), static::$session_id ) );
        $this->container->set('session', $this->session);

        //simulate is login
        $this->app->prepareUser();
        $try = $this->app->user->login(USERNAME, PASSWORD);

        //simulate request
        $this->request = new Request();
        $this->container->set('request', $this->request);

        //simulate controller
        $this->AdminNoteVM = new AdminNoteVM($this->container);
        $this->view = new View();
        $this->AdminNoteVM->setView($this->view);
    }
    
    public function testList()
    {
        $vm = $this->AdminNoteVM->form();
        $form = $this->view->form;
        $this->assertInstanceOf(Form::class, $form);
    }

    protected function tearDown(): void
    {
        $_POST = array();
    }

}
