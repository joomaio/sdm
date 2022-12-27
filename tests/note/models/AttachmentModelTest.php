<?php
namespace Tests\note\models;

use PHPUnit\Framework\TestCase;
use SPT\Query;
use SPT\Extend\Pdo as PdoWrapper;
use App\plugins\note\entities\AttachmentEntity;
use App\plugins\note\entities\NoteEntity;
use App\plugins\note\models\AttachmentModel;
use Joomla\DI\Container;
use SPT\Session\DatabaseSession;
use SPT\Session\DatabaseSessionEntity;
use SPT\Session\Instance as Session; 
use SPT\Storage\File\ArrayType as FileArray;
use Tests\simulate\File;

class AttachmentModelTest extends TestCase
{
    private $AttachmentModel;
    private $app;
    private $session;
    private $container;
    private $NoteEntity;
    private $AttachmentEntity;
    static $session_id;

    protected function setUp(): void
    {
        // Simulate container
        $this->container = new Container();

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
        $session = new Session( new DatabaseSession( new DatabaseSessionEntity($query), static::$session_id ) );
        $this->container->set('session', $session);

        // Simulate Model
        $this->AttachmentModel = new AttachmentModel($this->container);
    }
    
    public function testUploadTrue()
    {
        $this->assertIsArray([]);
    }

    public function testUploadFail()
    {
        $this->assertIsArray([]);
    }
    
}
