<?php
/**
 * SPT software - Entity
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic entity
 * 
 */

namespace App\plugins\note\entities;

use SPT\Storage\DB\Entity;

class NoteEntity extends Entity
{
    protected $table = '#__notes';
    protected $pk = 'id';

    public function getFields()
    {
        return [
                'id' => [
                    'type' => 'int',
                    'pk' => 1,
                    'option' => 'unsigned',
                    'extra' => 'auto_increment',
                ],
                'title' => [
                    'type' => 'varchar',
                    'limit' => 255,
                ],
                'file' => [
                    'type' => 'varchar',
                    'limit' => 255,
                    'null' => 'YES',
                ],
                'description' => [
                    'type' => 'longtext',
                    'null' => 'YES',
                ],
                'note' => [
                    'type' => 'longtext',
                    'null' => 'YES',
                ],
                'editor' => [
                    'type' => 'varchar',
                    'limit' => 100,
                    'null' => 'YES',
                ],
                'tags' => [
                    'type' => 'varchar',
                    'limit' => 1000,
                ],
                'created_at' => [
                    'type' => 'datetime',
                    'null' => 'YES',
                ],
                'created_by' => [
                    'type' => 'int',
                    'option' => 'unsigned',
                ],
                'modified_at' => [
                    'type' => 'datetime',
                    'null' => 'YES',
                ],
                'modified_by' => [
                    'type' => 'int',
                    'option' => 'unsigned',
                ],
        ];
    }
}