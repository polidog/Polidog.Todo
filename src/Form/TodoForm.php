<?php
namespace Polidog\Todo\Form;

use Aura\Html\Helper\Tag;
use Ray\Di\Di\Named;
use Ray\WebFormModule\AbstractForm;

class TodoForm extends AbstractForm
{
    /**
     * Form message
     *
     * submit_button: a name of button
     * required: required error message
     *
     * @var array
     */
    private $msg = [];

    /**
     * @Named("form_todo")
     */
    public function __construct(array $msg)
    {
        $this->msg = $msg;
    }

    public function __toString()
    {
        $form = $this->form([
            'method' => 'post',
            'action' => '/',
        ]);
        /* @var Tag $tag */
        $tag = $this->helper->get('tag');
        $form .= $tag('div', ['class' => 'form-group']);
        $form .= $this->input('title');
        $form .= $this->error('title');
        $form .= $this->helper->tag('/div') . PHP_EOL;
        // submit
        $form .= $this->input('submit');
        $form .= $this->helper->tag('/form');

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('title')
            ->setAttribs([
                'id' => 'title',
                'name' => 'title',
                'class' => 'form-control',
                'size' => 20
            ]);
        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => $this->msg['submit_button'],
                'class' => 'btn btn-primary'
            ]);
        // form validation
        $this->filter->validate('title')->is('strlenMin', 1);
        $this->filter->useFieldMessage('title', $this->msg['required']);
    }
}
