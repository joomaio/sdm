<?php

namespace Tests;
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


trait SetUpTestTrait
{    
    protected $container;
    protected $app;
    protected $user;
    protected $UserEntity;
    // protected $UserController;
    protected $session;
    protected static $session_id;

    protected function setUpTest(): void
    {
        $this->container = new Container();
        $this->app = new CliApp($this->container);
        AppIns::bootstrap($this->app, []); 
        
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
    }
}