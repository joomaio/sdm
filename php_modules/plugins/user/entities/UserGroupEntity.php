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

use SPT\User\SPT\UserGroupEntity as ParentEntity;

class UserGroupEntity extends ParentEntity
{
    public function getUserActive( $group_id)
    {
        $list = $this->db->select( 'usermap.user_id as usermap_id, users.*' )
                        ->table( '#__user_usergroup_map as usermap' )
                        ->join( 'LEFT JOIN #__users as users ON users.id = usermap.user_id ')
                        ->where(['usermap.group_id = ' .$group_id, 'users.status = 1']);

        return $list->countTotal(true)->list( 0, 0);
    }
}
