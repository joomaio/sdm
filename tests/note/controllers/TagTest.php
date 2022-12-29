<?php
namespace Tests\note\controllers;

use App\plugins\note\controllers\Tag;
use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;

class TagTest extends TestCase
{
    static $newID;
    static $removeID;
    static $file;

    protected function setUp(): void
    {
        $this->TagEntity = AppIns::factory('TagEntity');
        $this->app = AppIns::factory('app');

        $container = $this->app->getContainer();
        $this->TagController = new Tag($container);

        $user = AppIns::factory('user');
        $user->set('id', 1);
    }
    
    /**
     * @dataProvider prepareFilter()
     */
    public function testList($name)
    {
        $_POST['name'] = $name;

        $try = $this->TagController->list();

        $content = $this->app->get('respone_content');
        $this->assertEquals($content['status'], 'success');
        $this->assertIsArray($content['data']);
        $this->assertEquals($content['message'], '');
    }

    public function prepareFilter()
    {
        return [
            ['test'],
            [''],
            ['search'],
        ];
    }

    /**
     * @dataProvider prepareTag()
     */
    public function testAdd($name)
    {
        $_POST['name'] = $name;
        $find = $this->TagEntity->findOne(['name = "'. $name .'"']);
        if ($find && $name)
        {
            $status = 'fail';
            $message = 'Error: Title is already in use!';
        }
        elseif (!$name)
        {
            $status = 'fail';
            $message = 'Name invalid';
        }
        else
        {
            $status = 'success';
            $message = 'Create Tag sucess';
        }
        $this->TagController->add();
        $content = $this->app->get('respone_content');
        
        if ($content['data'])
        {
            static::$newID = $content['data']['id'];
        }
        $this->assertEquals($content['status'], $status);
        $this->assertEquals($content['message'], $message);

    }

    public function prepareTag()
    {
        return [
            ['test1'],
            [''],
            ['test2'],
            ['test3'],
            ['test2'],
        ];
    }
    

    protected function tearDown(): void
    {
        if (static::$newID)
        {
            $this->TagEntity->remove(static::$newID);
        }
        $_POST = array();
    }
}
