<?php
namespace tests\note\entities;

use PHPUnit\Framework\TestCase;
use SPT\Query;
use SPT\Extend\Pdo as PdoWrapper;
use App\plugins\note\entities\NoteEntity;

class NoteEntityTest extends TestCase
{
    private $NoteEntity;

    protected function setUp(): void
    {
        $config_content = require(PATH_CONFIG);

        $query = new Query(
            new PdoWrapper(
                $config_content['db'],
            ), ['#__' => $config_content['db']['prefix']]
        );
        
        $this->NoteEntity = new NoteEntity($query);
    }
    
    public function testGetFields()
    {
        $fields = $this->NoteEntity->getFields();
        $this->assertIsArray($fields);
    }

    /**
     * @depends testGetFields
     */
    public function testCheckAvailability()
    {
        $res = $this->NoteEntity->checkAvailability();
        $this->assertNotFalse($res);
    }
}
