<?php
use PHPUnit\Framework\TestCase;
use SPT\Extend\Pdo as PdoWrapper;
use SPT\App\Instance as AppIns;

class DBConnectTest extends TestCase
{
    public function testDB()
    {
        $config = AppIns::factory('config');
        $pdo = new PdoWrapper(
            $config->db,
        );

        $try = $pdo->connected ? true : false;
        if (!$try)
        {
            throw new \Exception( 'Incorrect database connection.');
        }

        $this->assertTrue($try);
    }
}