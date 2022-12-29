<?php
namespace Tests\note\controllers;

use PHPUnit\Framework\TestCase;
use SPT\App\Instance as AppIns;
use SPT\View\VM\View as View; 
use SPT\View\Gui\Form;

class AdminNoteVMTest extends TestCase
{
    protected function setUp(): void
    {
        $this->AdminNoteVM = AppIns::factory('AdminNoteVM');
        $this->request = AppIns::factory('request');
        $this->view = new View();
        $this->request->set('urlVars', ['id' => 0]);
        $this->AdminNoteVM->setView($this->view);
    }
    
    public function testForm()
    {
        $vm = $this->AdminNoteVM->form();
        $form = $this->view->form;
        $this->assertInstanceOf(Form::class, $form);
    }

}
