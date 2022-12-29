<?php
namespace Tests\note\controllers;

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;
use SPT\View\VM\View as View; 
use SPT\View\Gui\Listing;

class AdminNotesVMTest extends TestCase
{
    protected function setUp(): void
    {
        //simulate controller
        $this->AdminNotesVM = AppIns::factory('AdminNotesVM');
        $this->view = new View();
        $this->AdminNotesVM->setView($this->view);
    }
    
    public function testList()
    {
        $vm = $this->AdminNotesVM->list();
        $list = $this->view->list;
        $this->assertInstanceOf(Listing::class, $list);
    }

    public function tesFilter()
    {
        $_POST['search'] = 'test';
        $vm = $this->AdminNotesVM->list();
        $list = $this->view->list;
        $this->assertInstanceOf(Listing::class, $list);
    }

    protected function tearDown(): void
    {
        $_POST = array();
    }

}
