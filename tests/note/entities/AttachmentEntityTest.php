<?php
namespace Tests\note\entities;

use PHPUnit\Framework\TestCase;
use SPT\Query;
use SPT\Extend\Pdo as PdoWrapper;
use App\plugins\note\entities\AttachmentEntity;

class AttachmentEntityTest extends TestCase
{
    private $AttachmentEntity;

    protected function setUp(): void
    {
        $config_content = require(PATH_CONFIG);

        $query = new Query(
            new PdoWrapper(
                $config_content['db'],
            ), ['#__' => $config_content['db']['prefix']]
        );
        
        $this->AttachmentEntity = new AttachmentEntity($query);
    }
    
    public function testGetFields()
    {
        $fields = $this->AttachmentEntity->getFields();
        $this->assertIsArray($fields);
    }

    /**
     * @depends testGetFields
     */
    public function testCheckAvailability()
    {
        $res = $this->AttachmentEntity->checkAvailability();
        $this->assertNotFalse($res);
    }
}
