<?php

namespace Forms\Controls;

use Utils\Html;

class FileInput extends BaseControl
{

    const TYPE = 'file';

    /** @var \Utils\Html */
    protected $element;


    public function __construct($name, $label)
    {
        parent::__construct($name, $label);

        $this->createElement();
    }


    private function createElement()
    {
        $element = Html::el('input');

        $element->setAttribute('type', self::TYPE);
        $element->setAttribute('name', $this->name);

        $this->element = $element;
    }


    public function render()
    {
        $this->element->render();
    }

}
