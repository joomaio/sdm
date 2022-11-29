<?php
/**
 * SPT software - Entity
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic entity
 * 
 */

namespace App\plugins\user\entities;

use SPT\Storage\DB\Entity;

class UserEntity extends Entity
{
    protected $table = '#__users'; //table name
    protected $pk = 'u_id'; //primary key

    public function getFields()
    {
        return [
            // write your code here
            'u_id' => [
                'type' => 'int',
                'pk' => 1,
                'option' => 'unsigned',
                'extra' => 'auto_increment',
            ],
            'userid' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'psw' => [
                'type' => 'varchar',
                'limit' => 255,
                'default_value' => 'None',
            ],
            'u_type' => [
                'type' => 'enum',
                'limit' => "'view','update','admin'",
                'default_value' => 'view',
            ],
            's_type' => [
                'type' => 'enum',
                'limit' => "'home','teacher','school','extended_staff','extended_school','other'",
                'default_value' => 'other',
            ],
            't_count' => [
                'type' => 'int',
                'option' => 'unsigned',
                'default_value' => '1',
            ],
            'grade_level' => [
                'type' => 'varchar',
                'limit' => 25,
                'default_value' => 'Other',
            ],
            'u_email' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'u_l_name' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'u_f_name' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'phone' => [
                'type' => 'varchar',
                'limit' => 20,
                'default_value' => '000-000-0000',
            ],
            'school_name' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'addr1' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'addr2' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'city' => [
                'type' => 'varchar',
                'limit' => 30,
                'default_value' => 'None',
            ],
            'state' => [
                'type' => 'varchar',
                'limit' => 20,
                'default_value' => 'None',
            ],
            'zip' => [
                'type' => 'varchar',
                'limit' => 20,
                'default_value' => 'None',
            ],
            'country' => [
                'type' => 'varchar',
                'limit' => 50,
                'default_value' => 'None',
            ],
            'start_date' => [
                'type' => 'date',
                'null' => 'YES',
            ],
            'payment_date' => [
                'type' => 'date',
                'null' => 'YES',
            ],
            'expire_date' => [
                'type' => 'date',
                'null' => 'YES',
            ],
            'start_time' => [
                'type' => 'time',
                'null' => 'YES',
            ],
            'end_time' => [
                'type' => 'time',
                'null' => 'YES',
            ],
            'time_zone' => [
                'type' => 'varchar',
                'limit' => 20,
                'default_value' => 'PST',
            ],
            'gift_name' => [
                'type' => 'varchar',
                'limit' => 100,
                'default_value' => '',
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => 'YES',
            ],
            'created_by' => [
                'type' => 'int',
                'null' => 'YES',
            ],
            'modified_at' => [
                'type' => 'datetime',
                'null' => 'YES',
            ],
            'modified_by' => [
                'type' => 'int',
                'null' => 'YES',
            ],
        ];
    }
}