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

class MilestoneEntity extends Entity
{
    protected $table = '#__milestones';
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
                'start_date' => [
                    'type' => 'datetime',
                    'null' => 'YES',
                ],
                'end_date' => [
                    'type' => 'datetime',
                    'null' => 'YES',
                ],
                'description' => [
                    'type' => 'text',
                    'null' => 'YES',
                ],
                'status' => [
                    'type' => 'tinyint',
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

    public function toggleStatus( $id, $action)
    {
        $item = $this->findByPK($id);
        return $this->db->table( $this->table )->update([
            'status' => $status,
        ], ['id' => $id ]);
    }
}