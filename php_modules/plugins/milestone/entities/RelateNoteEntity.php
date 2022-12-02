<?php
/**
 * SPT software - Entity
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic entity
 * 
 */

namespace App\plugins\milestone\entities;

use SPT\Storage\DB\Entity;

class RelateNoteEntity extends Entity
{
    protected $table = '#__relate_notes';
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
                'request_id' => [
                    'type' => 'int',
                    'option' => 'unsigned',
                ],
                'note_id' => [
                    'type' => 'int',
                    'option' => 'unsigned',
                    'null' => 'YES'
                ],
                'description' => [
                    'type' => 'text',
                    'null' => 'YES'
                ],
        ];
    }

    public function toggleStatus( $id, $action)
    {
        $item = $this->findByPK($id);
        return $this->db->table( $this->table )->update([
            'status' => $status,
        ], ['id' => $id ]);
    }
}