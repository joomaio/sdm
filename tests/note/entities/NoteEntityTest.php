<?php
namespace Tests\note\entities;

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;

class NoteEntityTest extends TestCase
{
    private $NoteEntity;

    protected function setUp(): void
    {
        $this->NoteEntity = AppIns::factory('NoteEntity');
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
