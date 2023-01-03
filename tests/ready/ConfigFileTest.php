<?php

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;

class ConfigFileTest extends TestCase
{

    public function testConfig()
    {
        $config = AppIns::factory('config');
        if( !file_exists( $config->getPaths()[0] ))
        {
            throw new \Exception('Config file has not been created.');
        }

        $this->assertTrue(true);
    }
}