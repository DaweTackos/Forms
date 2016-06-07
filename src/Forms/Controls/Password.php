<?php

namespace Forms\Controls;

use Utils\Html;


class Password extends TextBase
{

    const TYPE = 'password';


    public function __construct($name, $label = null, $size = null)
    {
        parent::__construct($name, $label);

        $this->createElement();

        !$size ?: $this->element->setAttribute('size', $size);
    }


    private function createElement()
    {
        $element = Html::el('input');

        $element->setAttribute('type', self::TYPE);
        $element->setAttribute('name', $this->name);

        $this->element = $element;
    }

}

