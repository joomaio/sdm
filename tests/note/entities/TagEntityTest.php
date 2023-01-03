<?php
namespace Tests\note\entities;

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;

class TagEntityTest extends TestCase
{
    private $TagEntity;

    protected function setUp(): void
    {
        $this->TagEntity = AppIns::factory('TagEntity');
    }
    
    public function testGetFields()
    {
        $fields = $this->TagEntity->getFields();
        $this->assertIsArray($fields);
    }

    /**
     * @depends testGetFields
     */
    public function testCheckAvailability()
    {
        $res = $this->TagEntity->checkAvailability();
        $this->assertNotFalse($res);
    }
}
