<?php
namespace Tests\note\controllers;

use App\plugins\note\controllers\Note;
use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;

class NoteTest extends TestCase
{
    static $newID;
    static $removeID;
    static $file;

    protected function setUp(): void
    {
        $this->NoteEntity = AppIns::factory('NoteEntity');
        $this->request = AppIns::factory('request');
        $this->session = AppIns::factory('session');
        $this->app = AppIns::factory('app');

        $container = $this->app->getContainer();
        $this->NoteController = new Note($container);

        $user = AppIns::factory('user');
        $user->set('id', 1);
    }

    /**
     * @dataProvider prepareNote()
     */
    public function testAdd($data, $status)
    {
        foreach($data as $key => $value)
        {
            if($key != 'files')
            {
                $_POST[$key] = $value;
            }
            else
            {
                $_FILES[$key] = $value;
            }
        }

        $this->NoteController->add();
        $url = $this->app->get('url_redirect');
        $session = $this->session->get('flashMsg');
        if ($status)
        {
            $newNote = $this->NoteEntity->list(0, 1, [], 'id desc');
            static::$newID = $newNote[0]['id'];
            $this->assertNotEquals($url, SITE_URL.'note/0');
        }
        else
        {
            $this->assertEquals($url, SITE_URL.'note/0');
        }
    }

    /**
     * @depends testAdd
     * @dataProvider prepareNote()
     */
    public function testUpdate($data, $status)
    {
        $newNote = $this->NoteEntity->add([
            'title' => 'Note Test',
            'tags' => '',
            'created_by' => 0,
            'modified_by' => 0,
        ]);

        $this->assertNotFalse($newNote);
        
        $try = true;
        if (!$newNote)
        {
            $try = false;
        }
        static::$newID = $newNote;
        $this->assertTrue($try);

        foreach($data as $key => $value)
        {
            if($key != 'files')
            {
                $_POST[$key] = $value;
            }
            else
            {
                $_FILES[$key] = $value;
            }
        }

        $this->request->set('urlVars', ['id' => $newNote]);

        $this->NoteController->update();
        $session = $this->session->get('flashMsg', '');
        if ($status)
        {
            $this->assertEquals($session, 'Updated successfully');
        }
        else
        {
            $this->assertNotEquals($session, 'Updated successfully');
        }      
    }

    public function testDelete()
    {
        $id = $this->prepareDelete();
        $this->request->set('urlVars', ['id' => $id]);
        $this->NoteController->delete();
        
        $message = $this->session->get('flashMsg', '');
        return $this->assertEquals($message, '1 deleted record(s)');
    }

    public function testMulDelete()
    {
        $count = 2;
        $id = $this->prepareDelete($count);
        $this->request->set('urlVars', ['id' => '']);

        $_POST['ids'] = $id;

        $this->NoteController->delete();
        
        $message = $this->session->get('flashMsg', '');
        return $this->assertEquals($message, $count.' deleted record(s)');
    }

    public function prepareDelete($number = 1)
    {
        if ($number == 1)
        {
            $tmp = $this->NoteEntity->add([
                'title' => 'Note Test '. strtotime('now'),
                'tags' => '',
                'created_by' => 0,
                'modified_by' => 0,
            ]);

            return $tmp ? $tmp : 0;
        }
        else
        {
            $result = [];
            for ($i=0; $i < $number; $i++) { 
                # code...
                $tmp = $this->NoteEntity->add([
                    'title' => 'Note Test '. $i .'_'. strtotime('now'),
                    'tags' => '',
                    'created_by' => 0,
                    'modified_by' => 0,
                ]);
                $result[] = $tmp ? $tmp : 0;
            }
            return $result;
        }

    }

    public function prepareNote()
    {
        $notes[] = [[
                'title' => '',
                'tags' => '',
                'description' => '',
                'note' => '',
                'files' => [
                    'name' => [''],
                    'tmp_name' => [''],
                    'type' => [''],
                    'size' => [''],
                ],
            ],
            false,
        ];

        $notes[] = [
            [
                'title' => 'Note Test Title',
                'tags' => '',
                'description' => '',
                'note' => '',
                'files' => [
                    'name' => [''],
                    'tmp_name' => [''],
                    'type' => [''],
                    'size' => [''],
                ],
            ],
            true,
        ];

        return $notes;
    }

    protected function tearDown(): void
    {
        if (static::$newID)
        {
            $this->NoteEntity->remove(static::$newID);
        }

        $_POST = array();
    }
}
