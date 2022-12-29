<?php
namespace Tests\note\models;

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;

class AttachmentModelTest extends TestCase
{
    private $AttachmentModel;
    private $AttachmentEntity;
    static $att_id;
    static $file;
    static $note_id;

    protected function setUp(): void
    {
        $this->AttachmentModel = AppIns::factory('AttachmentModel');
        $this->AttachmentEntity = AppIns::factory('AttachmentEntity');
        $this->NoteEntity = AppIns::factory('NoteEntity');
        $this->user = AppIns::factory('user');
        $this->user->set('id', 1);
        // create note
        $note = $this->NoteEntity->findOne(['title', 'Attactment Test']);
        if (!$note)
        {
            $note = $this->NoteEntity->add([
                'title' => 'Attactment Test',
                'tags' => '',
                'created_by' => 0,
                'modified_by' => 0,
            ]);
        }
        static::$note_id = is_array($note) && $note ? $note['id'] : $note;
    }
    
    /**
     * @dataProvider prepareDataTrue()
     */
    public function testUploadTrue($file)
    {
        $try = $this->AttachmentModel->upload($file, static::$note_id);
        if ($try)
        {
            static::$att_id = $try;
        }
        $this->assertNotFalse($try);
    }

    /**
     * @dataProvider prepareDataFalse()
     */
    public function testUploadFail($file)
    {
        try {
            $try = $this->AttachmentModel->upload($file, $this->note_id);
        } catch (\Throwable $th) {
            $try = false;
        }
        
        $this->assertFalse($try);
    }

    public function prepareDataTrue()
    {
        // create file sample
        static::$file = [];
        $try = file_put_contents(PUBLIC_PATH. 'test.png', '');
        static::$file[] = PUBLIC_PATH. 'test.png';
        $try = file_put_contents(PUBLIC_PATH. 'test.jpg', '');
        static::$file[] = PUBLIC_PATH. 'test.jpg';
        $file[] = [
            'name' => 'test.png',
            'tmp_name' => PUBLIC_PATH. 'test.png',
            'type' => mime_content_type(PUBLIC_PATH. 'test.png'),
            'size' => filesize(PUBLIC_PATH. 'test.png'),
        ];
        $file[] = [
            'name' => 'test.jpg',
            'tmp_name' => PUBLIC_PATH. 'test.jpg',
            'type' => mime_content_type(PUBLIC_PATH. 'test.jpg'),
            'size' => filesize(PUBLIC_PATH. 'test.jpg'),
        ];

        return [
            $file,
        ];
    }

    public function prepareDataFalse()
    {
        // create file sample
        $try = file_put_contents(PUBLIC_PATH. 'test.sql', '');
        static::$file[] = PUBLIC_PATH. 'test.sql';
        $file = [
            'name' => 'test.sql',
            'tmp_name' => PUBLIC_PATH. 'test.sql',
            'type' => mime_content_type(PUBLIC_PATH. 'test.sql'),
            'size' => filesize(PUBLIC_PATH. 'test.sql'),
        ];

        return [
            [$file],
        ];
    }

    public function prepareFile()
    {
        // create file sample
        $try = file_put_contents(PUBLIC_PATH. 'test_remove.png', '');
        $file[] = [
            'name' => 'test_remove.png',
            'tmp_name' => PUBLIC_PATH. 'test_remove.png',
            'type' => mime_content_type(PUBLIC_PATH. 'test_remove.png'),
            'size' => filesize(PUBLIC_PATH. 'test_remove.png'),
        ];

        return [
            $file,
        ];
    }

    /**
     * @depends testUploadTrue
     * @dataProvider prepareFile()
     */
    public function testRemoveTrue($file)
    {
        $id = $this->AttachmentModel->upload($file, $this->note_id);

        if (!$id)
        {
            $try = false;
        }
        else
        {
            static::$file[] = $file['tmp_name'];
            $try = $this->AttachmentModel->remove($id);
        }

        $this->assertTrue($try);
    }

    /**
     * @depends testUploadTrue
     */
    public function testRemoveFalse()
    {
        $id = -1;
        $try = $this->AttachmentModel->remove($id);
        $this->assertFalse($try);
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
        static::$file = [];

        if (static::$att_id)
        {
            $this->AttachmentEntity->remove(static::$att_id);
        }

        static::$att_id = '';
    }
}
