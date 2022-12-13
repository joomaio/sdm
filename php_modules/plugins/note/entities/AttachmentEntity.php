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

class AttachmentEntity extends Entity
{
    protected $table = '#__attachments';
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
                'note_id' => [
                    'type' => 'int',
                ],
                'name' => [
                    'type' => 'varchar',
                    'limit' => 255,
                ],
                'path' => [
                    'type' => 'varchar',
                    'limit' => 255,
                ],
                'uploaded_at' => [
                    'type' => 'datetime',
                    'null' => 'YES',
                ],
                'uploaded_by' => [
                    'type' => 'int',
                    'option' => 'unsigned',
                ],
        ];
    }
}