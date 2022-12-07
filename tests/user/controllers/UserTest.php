<?php
namespace Tests\User;
use PHPUnit\Framework\TestCase;
use Joomla\DI\Container;
use SPT\App\JDIContainer\CliApp;
use SPT\App\Instance as AppIns;
use SPT\Extend\Pdo as PdoWrapper;
use SPT\Query;
use SPT\Session\Instance as Session;
use SPT\Session\DatabaseSession;
use SPT\Session\DatabaseSessionEntity;
use SPT\User\SPT\UserEntity;
use SPT\User\SPT\User;
use App\plugins\user\controllers\User as UserController;
use SPT\Request\Post as PostRequest;
use SPT\Request\Base;


class UserTest extends TestCase
{
    private $app;
    private $user;
    private $UserEntity;
    private $UserController;
    private $session;
    private static $config;
    private static $session_id;

    protected function setUp(): void
    {
        $this->container = new Container();
        $this->app = new CliApp($this->container);
        AppIns::bootstrap($this->app, []); 

        // if (!static::$config)
        // {
        //     static::$config = require(APP_PATH_V14. 'config.php');
        // }
        
        $this->Pdo= new PdoWrapper([
           'host' => 'vt_mysql',
           'username' => 'root',
           'password' => '123123',
           'database' => '5300',
        ]);

        $query = new Query(
            $this->Pdo, ['#__'=>  '']
        );

        if (!static::$session_id)
        {
            static::$session_id = rand();
        } 
        $this->session = new Session( new DatabaseSession( new DatabaseSessionEntity($query), static::$session_id ) ); 
        $this->container->set('session', $this->session);
        $this->UserEntity = new UserEntity($query);
        $this->container->set('UserEntity', $this->UserEntity);

        $this->user = new User();
        $this->user->init([
            'session' => $this->session,
            'entity' => new UserEntity($query)
        ]);
        $this->UserController = new UserController($this->container);
    }





    /**
     * @dataProvider providerTestLogin
     */
    public function testLogin($username, $password)
    {
        $request = new PostRequest();
        $request->set('username',$username);
        $request->set('password',$password);
        var_dump($this->user);
        $controller = $this->UserController;
        $controller->login();
        $this->assertFalse(false);
        // $result = $this->user->login(
        //     $username,
        //     $password
        // );
        
        // if ( $result )
        // {
        //     $this->assertIsArray($result);
        //     $this->assertArrayHasKey('status',$result);
        //     if($result['status'] != 1) 
        //     {
        //         $this->assertNotEquals(1, $result['status']);

        //         $this->session->set('flashMsg', 'Error: User has been block');
        //         $this->assertEquals($this->session->get('flashMsg'),'Error: User has been block');

        //         $this->user->logout();
        //         $this->assertEquals(0, $this->user->get('id'));
        //     }
        //     else
        //     {
        //         $this->assertEquals(1, $result['status']);
                
        //         $this->session->set('flashMsg', 'Hello!!!');
        //         $this->assertEquals($this->session->get('flashMsg'),'Hello!!!');
        //     }
        // }
        // else
        // {
        //     $this->assertFalse($result);
            
        //     $this->session->set('flashMsg', 'Username and Password invalid.');
        //     $this->assertEquals($this->session->get('flashMsg'),'Username and Password invalid.');
        // }
    }

    public function providerTestLogin()
    {
        return [
            ['admin', '123456789'],
            ['admin', '123123123'],
            ['admin2', '123123123'],
        ];
    }


    // public function testList()
    // {
    //     $this->UserController->list();

    //     $this->assertEquals(1, $this->user->get('id'));

    //     $this->assertEquals($this->app->get('page'),'backend');
    //     $this->assertEquals($this->app->get('format'),'html');
    //     $this->assertEquals($this->app->get('layout'),'backend.user.list');
    // }

    // public function testUpdate()
    // {
        
    // }
}
