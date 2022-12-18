<?php
/**
 * SPT software - Entity
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic entity
 * 
 */

namespace App\plugins\version\entities;

use SPT\Storage\DB\Entity;

class VersionEntity extends Entity
{
    protected $table = '#__versions'; //table name
    protected $pk = 'id'; //primary key

    public function getFields()
    {
        return [
            'id' => [
                'type' => 'int',
                'pk' => 1,
                'option' => 'unsigned',
                'extra' => 'auto_increment',
            ],
            'name' => [
                'type' => 'varchar',
                'limit' => 255,
            ],
            'release_date' => [
                'type' => 'datetime',
                'null' => 'YES',
            ],
            'status' => [
                'type' => 'tinyint',
            ],
            'description' => [
                'type' => 'text',
                'null' => 'YES',
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