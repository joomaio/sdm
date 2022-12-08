<?php
/**
 * SPT software - PHP Session
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: PHP Session
 * 
 */

namespace App\plugins\user\entities;

use SPT\Storage\DB\DipatchableEntity as Entity;

class GroupEntity extends Entity
{ 
    protected $affix = 'Group';
    protected $table = '#__user_groups';
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
                'name' => [
                    'type' => 'varchar',
                    'limit' => 50,
                ],
                'description' => [
                    'type' => 'text',
                ],
                'access' => [
                    'type' => 'text',
                ],
                'status' => [
                    'type' => 'int',
                ],
                'created_at' => [
                    'type' => 'datetime',
                    'null' => 'YES',
                ],
                'created_by' => [
                    'type' => 'tinyint',
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

    public function toggleActive( $id , $action)
    {
        $item = $this->findByPK($id);
        $status = $action == 'active' ? 1 : 0;
        return $this->db->table( $this->table )->update([
            'status' => $status,
        ], ['id' => $id ]);
    }

}
