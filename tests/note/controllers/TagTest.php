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

use App\plugins\note\entities\AttachmentEntity;
use App\plugins\note\entities\NoteEntity;
use App\plugins\note\entities\TagEntity;
use App\plugins\note\models\AttachmentModel;
use App\plugins\note\controllers\Tag;

use Tests\simulate\appTest;
use Tests\simulate\File;

class TagTest extends TestCase
{
    private $NoteController;
    private $app;
    private $session;
    private $container;
    private $NoteEntity;
    private $TagEntity;
    private $AttachmentEntity;
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
        $this->container->set('AttachmentEntity', $this->AttachmentEntity); 
        $this->container->set('TagEntity', $this->TagEntity); 

        // Simulate File
        $this->container->set('file', new File()); 

        // Simulate session
        if (!static::$session_id)
        {
            static::$session_id = rand();
        } 
        $this->session = new Session( new DatabaseSession( new DatabaseSessionEntity($query), static::$session_id ) );
        $this->container->set('session', $this->session);

        // Simulate Model
        $this->AttachmentModel = new AttachmentModel($this->container);
        $this->container->set('AttachmentModel', $this->AttachmentModel);

        //simulate is login
        $this->app->prepareUser();
        $try = $this->app->user->login(USERNAME, PASSWORD);

        //simulate request
        $this->request = new Request();
        $this->container->set('request', $this->request);

        //simulate controller
        $this->TagController = new Tag($this->container);
    }
    
    /**
     * @dataProvider prepareFilter()
     */
    public function testList($name)
    {
        $_POST['name'] = $name;

        $try = $this->TagController->list();

        $content = $this->app->get('respone_content');
        $this->assertEquals($content['status'], 'success');
        $this->assertIsArray($content['data']);
        $this->assertEquals($content['message'], '');
    }

    public function prepareFilter()
    {
        return [
            ['test'],
            [''],
            ['search'],
        ];
    }

    /**
     * @dataProvider prepareTag()
     */
    public function testAdd($name)
    {
        $_POST['name'] = $name;
        $find = $this->TagEntity->findOne(['name = "'. $name .'"']);
        if ($find && $name)
        {
            $status = 'fail';
            $message = 'Error: Title is already in use!';
        }
        elseif (!$name)
        {
            $status = 'fail';
            $message = 'Name invalid';
        }
        else
        {
            $status = 'success';
            $message = 'Create Tag sucess';
        }
        $this->TagController->add();
        $content = $this->app->get('respone_content');
        
        if ($content['data'])
        {
            static::$newID = $content['data']['id'];
        }
        $this->assertEquals($content['status'], $status);
        $this->assertEquals($content['message'], $message);

    }

    public function prepareTag()
    {
        return [
            ['test1'],
            [''],
            ['test2'],
            ['test3'],
            ['test2'],
        ];
    }
    

    protected function tearDown(): void
    {
        if (static::$newID)
        {
            $this->TagEntity->remove(static::$newID);
        }
        $_POST = array();
    }
}
