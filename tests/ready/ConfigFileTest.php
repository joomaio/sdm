<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config.php';

class ConfigFileTest extends TestCase
{

    public function testConfig()
    {
        $path = PATH_CONFIG;
        if( !file_exists( $path ))
        {
            throw new \Exception('Config file has not been created.');
        }

        $this->assertTrue(true);
    }
}