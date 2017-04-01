<?php
namespace Polidog\Todo\Form;

use PHPUnit\Framework\TestCase;
use Ray\WebFormModule\FormFactory;

class TodoFormTest extends TestCase
{
    /**
     * @var TodoForm
     */
    private $form;

    protected function setUp()
    {
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

    public function testFormView()
    {
        $formHtml = (string) $this->form;
        $expected = '<form method="post" action="/" enctype="multipart/form-data"><div class="form-group"><input id="title" type="text" name="title" class="form-control" size="20" />
</div>
<input type="submit" name="submit" value="登録" class="btn btn-primary" />
</form>';
        $this->assertSame($expected, $formHtml);
    }
}
