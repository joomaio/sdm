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
use App\plugins\note\models\AttachmentModel;
use App\plugins\note\controllers\Attachment;

use Tests\simulate\appTest;
use Tests\simulate\File;

class AttachmentTest extends TestCase
{
    private $AttachmentController;
    private $app;
    private $session;
    private $container;
    private $NoteEntity;
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
        $this->container->set('NoteEntity', $this->NoteEntity); 
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
        $this->AttachmentController = new Attachment($this->container);
    }
    
    public function testDelete()
    {
        $id = $this->prepareDelete();
        $this->request->set('urlVars', ['id' => $id]);

        $this->AttachmentController->delete($id);
        $find = $this->AttachmentEntity->findByPK($id);
    
        $this->assertFalse($find);
    }

    public function prepareDelete()
    {
        $id = $this->AttachmentEntity->add([
            'note_id' => 0,
            'name' => 'test',
            'path' => 'test.png',
            'uploaded_by' => 0,
        ]);

        return $id ? $id : 0;
    }

}
