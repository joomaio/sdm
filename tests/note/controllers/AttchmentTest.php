<?php
namespace Tests\note\controllers;

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;
use App\plugins\note\controllers\Attachment;

class AttachmentTest extends TestCase
{
    private $AttachmentController;
    private $AttachmentEntity;

    static $newID;
    static $removeID;
    static $file;

    protected function setUp(): void
    {
        $this->AttachmentEntity = AppIns::factory('AttachmentEntity');
        $this->app = AppIns::factory('app');
        $this->request = AppIns::factory('request');

        $container = $this->app->getContainer();
        $this->AttachmentController = new Attachment($container);

        $user = AppIns::factory('user');
        $user->set('id', 1);
    }
    
    public function testDelete()
    {
        $id = $this->prepareDelete();
        $this->request->set('urlVars', ['id' => $id]);

        $this->AttachmentController->delete($id);
        $find = $this->AttachmentEntity->findByPK($id);
    
        $this->assertFalse($find);
    }

    public function prepareDelete()
    {
        $id = $this->AttachmentEntity->add([
            'note_id' => 0,
            'name' => 'test',
            'path' => 'test.png',
            'uploaded_by' => 0,
        ]);

        return $id ? $id : 0;
    }

}
