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
use App\plugins\note\controllers\Note;

use Tests\simulate\appTest;
use Tests\simulate\File;

class NoteTest extends TestCase
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
        $this->NoteController = new Note($this->container);
    }
    
    // public function testDetail()
    // {
    //     $id = $this->NoteEntity->list(0, 1, [], 'id desc');
    //     if ($try)
    //     {
    //         static::$att_id = $try;
    //     }
    //     $this->assertNotFalse($try);
    // }

    /**
     * @dataProvider prepareNote()
     */
    public function testAdd($data, $status)
    {
        foreach($data as $key => $value)
        {
            if($key != 'files')
            {
                $_POST[$key] = $value;
            }
            else
            {
                $_FILES[$key] = $value;
            }
        }

        $this->NoteController->add();
        $url = $this->app->get('url_redirect');
        if ($status)
        {
            $newNote = $this->NoteEntity->list(0, 1, [], 'id desc');
            static::$newID = $newNote[0]['id'];
            $this->assertNotEquals($url, SITE_URL.'note/0');
        }
        else
        {
            $this->assertEquals($url, SITE_URL.'note/0');
        }
    }

    /**
     * @depends testAdd
     * @dataProvider prepareNote()
     */
    public function testUpdate($data, $status)
    {
        $newNote = $this->NoteEntity->add([
            'title' => 'Note Test',
            'tags' => '',
            'created_by' => 0,
            'modified_by' => 0,
        ]);

        $this->assertNotFalse($newNote);
        
        $try = true;
        if (!$newNote)
        {
            $try = false;
        }
        static::$newID = $newNote;
        $this->assertTrue($try);

        foreach($data as $key => $value)
        {
            if($key != 'files')
            {
                $_POST[$key] = $value;
            }
            else
            {
                $_FILES[$key] = $value;
            }
        }

        $this->request->set('urlVars', ['id' => $newNote]);

        $this->NoteController->update();
        $session = $this->session->get('flashMsg', '');
        if ($status)
        {
            $this->assertEquals($session, 'Updated successfully');
        }
        else
        {
            $this->assertNotEquals($session, 'Updated successfully');
        }      
    }

    public function testDelete()
    {
        $id = $this->prepareDelete();
        $this->request->set('urlVars', ['id' => $id]);
        $this->NoteController->delete();
        
        $message = $this->session->get('flashMsg', '');
        return $this->assertEquals($message, '1 deleted record(s)');
    }

    public function testMulDelete()
    {
        $count = 2;
        $id = $this->prepareDelete($count);
        $this->request->set('urlVars', ['id' => '']);

        $_POST['ids'] = $id;

        $this->NoteController->delete();
        
        $message = $this->session->get('flashMsg', '');
        return $this->assertEquals($message, $count.' deleted record(s)');
    }

    public function prepareDelete($number = 1)
    {
        if ($number == 1)
        {
            $tmp = $this->NoteEntity->add([
                'title' => 'Note Test '. strtotime('now'),
                'tags' => '',
                'created_by' => 0,
                'modified_by' => 0,
            ]);

            return $tmp ? $tmp : 0;
        }
        else
        {
            $result = [];
            for ($i=0; $i < $number; $i++) { 
                # code...
                $tmp = $this->NoteEntity->add([
                    'title' => 'Note Test '. $i .'_'. strtotime('now'),
                    'tags' => '',
                    'created_by' => 0,
                    'modified_by' => 0,
                ]);
                $result[] = $tmp ? $tmp : 0;
            }
            return $result;
        }

    }

    public function prepareNote()
    {
        $notes[] = [[
                'title' => '',
                'tags' => '',
                'description' => '',
                'note' => '',
                'files' => [
                    'name' => [''],
                    'tmp_name' => [''],
                    'type' => [''],
                    'size' => [''],
                ],
            ],
            false,
        ];

        $notes[] = [
            [
                'title' => 'Note Test Title',
                'tags' => '',
                'description' => '',
                'note' => '',
                'files' => [
                    'name' => [''],
                    'tmp_name' => [''],
                    'type' => [''],
                    'size' => [''],
                ],
            ],
            true,
        ];

        return $notes;
    }

    protected function tearDown(): void
    {
        if (static::$newID)
        {
            $this->NoteEntity->remove(static::$newID);
        }
    }
}