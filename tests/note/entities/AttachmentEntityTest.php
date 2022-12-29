<?php
namespace Tests\note\entities;

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;

class AttachmentEntityTest extends TestCase
{
    private $AttachmentEntity;

    protected function setUp(): void
    {
        $this->AttachmentEntity = AppIns::factory('AttachmentEntity');
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
