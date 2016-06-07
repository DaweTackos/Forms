<?php

namespace Forms\Controls;

use Utils\Html;

class Checkbox extends BaseControl
{

    const TYPE = 'checkbox';


    public function __construct($name, $label = null)
    {
        parent::__construct($name, $label);

        $this->createElement();
    }


    private function createElement()
    {
        $element = Html::el('input');
        $element->setAttribute('type', self::TYPE);

        $this->element = $element;
    }


    /**
     * Set value to element
     *
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->element->setAttribute('value', $value);

        return $this;
    }

}

