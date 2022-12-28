<?php
/**
 * SPT software - Model
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic model
 * 
 */

namespace App\plugins\version\models;

use SPT\JDIContainer\Base; 

class VersionModel extends Base 
{ 
    public function getVersion()
    {
        $version_level = (int) $this->OptionModel->get('version_level', 1);
        $version_level_deep = (int) $this->OptionModel->get('version_level_deep', 1);

        $version_lastest = $this->VersionEntity->list(0, 1, [], 'id desc');
        $current_version = $version_lastest ? $version_lastest[0]['version'] : '0.0.0';
        
        $vParts = explode('.', $current_version);
        $max = (int) str_repeat('9', $version_level);
        $newVersion = '';
        $ins = 1;
        for ($i = $version_level_deep; $i > 0 ; $i--) 
        { 
            # code...
            $tmp = isset($vParts[$i - 1]) ? (int) $vParts[$i - 1] + $ins : 0;
            $ins = 0;
            if ($tmp > $max)
            {
                $ins = 1;
                $tmp = 0;
            }

            if ($version_level - strlen((string) $tmp) > 0)
            {
                $tmp = str_repeat('0', $version_level - strlen((string) $tmp)) . $tmp;
            }

            $newVersion = strlen($newVersion) ? $tmp . '.' . $newVersion : $tmp;
        }

        return $newVersion;
    }

}
