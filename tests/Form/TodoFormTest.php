<?php
namespace Polidog\Todo\Resource\Page;

namespace Polidog\Todo\Form;

use Ray\WebFormModule\FormFactory;

class TodoFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TodoForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        $this->form = (new FormFactory())->newInstance(TodoForm::class);
    }

    public function testFailedEmpty()
    {
        $submit = [];
        $isValid = $this->form->apply($submit);
        $this->assertFalse($isValid);
    }

    public function testFailedEmptyVale()
    {
        $submit = ['title' => ''];
        $isValid = $this->form->apply($submit);
        $this->assertFalse($isValid);
        $msg = $this->form->getFailureMessages();
        $expected = ['title' => ['必ず入力してください']];
        $this->assertSame($expected, $msg);
    }

    public function testOk()
    {
        $submit = ['title' => 'test'];
        $isValid = $this->form->apply($submit);
        $this->assertTrue($isValid);
    }
}
