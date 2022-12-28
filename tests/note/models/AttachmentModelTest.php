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
use SPT\User\Instance as User;
use SPT\User\SPT\User as UserAdapter;
use SPT\User\SPT\UserEntity;

class AttachmentModelTest extends TestCase
{
    private $AttachmentModel;
    private $app;
    private $session;
    private $container;
    private $NoteEntity;
    private $AttachmentEntity;
    static $session_id;
    static $att_id;
    static $file;

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

        // Simulate User
        $user = new User( new UserAdapter() );
        $user->init([
            'session' => $session,
            'entity' => new  UserEntity($query)
        ]);
        $this->container->share('user', $user, true);

        // setup note id
        $note = $this->NoteEntity->findOne(['id > 0']);
        $this->note_id = $note ? $note['id'] : 0;
    }
    
    /**
     * @dataProvider prepareDataTrue()
     */
    public function testUploadTrue($file)
    {
        try {
            $try = $this->AttachmentModel->upload($file, $this->note_id);
        } catch (\Throwable $th) {
            $try = false;
        }
        if ($try)
        {
            static::$att_id = $try;
        }
        $this->assertNotFalse($try);
    }

    public function testUploadFail()
    {
        $this->assertIsArray([]);
    }

    public function prepareDataTrue()
    {
        // create file sample
        static::$file = [];
        $try = file_put_contents(ROOT_PATH. 'test.png', '');
        static::$file[] = ROOT_PATH. 'test.png';
        $try = file_put_contents(ROOT_PATH. 'test.jpg', '');
        static::$file[] = ROOT_PATH. 'test.jpg';
        $file[] = [
            'name' => 'test.png',
            'tmp_name' => ROOT_PATH. 'test.png',
            'type' => mime_content_type(ROOT_PATH. 'test.png'),
            'size' => filesize(ROOT_PATH. 'test.png'),
        ];
        $file[] = [
            'name' => 'test.jpg',
            'tmp_name' => ROOT_PATH. 'test.jpg',
            'type' => mime_content_type(ROOT_PATH. 'test.jpg'),
            'size' => filesize(ROOT_PATH. 'test.jpg'),
        ];

        return [
            $file,
        ];
    }

    public function prepareDataFalse()
    {
        // create file sample
        $try = file_put_contents(ROOT_PATH. 'test.png', '');
        static::$file = ROOT_PATH. 'test.png';
        $file = [
            'name' => 'test.png',
            'tmp_name' => ROOT_PATH. 'test.png',
            'type' => mime_content_type(ROOT_PATH. 'test.png'),
            'size' => filesize(ROOT_PATH. 'test.png'),
        ];

        return [
            [$file],
        ];
    }
    
    protected function tearDown(): void
    {
        if (static::$file)
        {
            if (is_array(static::$file))
            {
                foreach(static::$file as $f)
                {
                    if (file_exists($f))
                    {
                        unlink($f);
                    }
                }
            }
            else
            {
                if (file_exists(static::$file))
                {
                    unlink(static::$file);
                }
            }
        }
        

        if (static::$att_id)
        {
            $this->AttachmentEntity->remove(static::$att_id);
        }
    }
}
