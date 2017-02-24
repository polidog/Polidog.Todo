<?php
namespace Polidog\Todo\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;

class TodoForm extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('title')
            ->setAttribs([
                'id' => 'todo[title]',
                'name' => 'todo[title]',
                'class' => 'form-control',
                'size' => 20
            ]);

        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => '登録',
                'class' => 'btn btn-primary'
            ]);

        // validationの設定
        $this->filter->validate('title')->is('strlenMin', 1);
        $this->filter->useFieldMessage('title', '必ず入力してください');
    }

    public function __toString()
    {
        $form = $this->form([
            'method' => 'post',
            'action' => '/',
        ]);

        /** @var Tag $tag */
        $tag  = $this->helper->get('tag');
        $form .= $tag('div', ['class' => 'form-group']);
        $form .= $this->input('title');
        $form .= $this->error('title');
        $form .= $this->helper->tag('/div') . PHP_EOL;

        // submit
        $form .= $this->input('submit');
        $form .= $this->helper->tag('/form');

        return $form;
    }
}
