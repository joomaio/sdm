<?php
use PHPUnit\Framework\TestCase;
use SPT\Extend\Pdo as PdoWrapper;
require __DIR__ . '/../config.php';

class DBConnectTest extends TestCase
{
    public function testDB()
    {
        $path = PATH_CONFIG;
        $config_content = require($path);
        $pdo = new PdoWrapper(
            $config_content['db'],
        );

        $try = $pdo->connected ? true : false;
        if (!$try)
        {
            throw new \Exception( 'Incorrect database connection.');
        }

        $this->assertTrue($try);
    }
}