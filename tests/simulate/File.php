<?php
namespace Tests\simulate;

use SPT\File as TestFile;

class File extends TestFile
{
    public function upload(array $file)
    {
        if( ! $this->check($file) ) return false;
 
        if ( !copy($file["tmp_name"], $this->targetFile)) {
            $this->error = $newFileName. ': File can not upload, please check folder permission.';
            return false;
        }

        return true;
    }
}