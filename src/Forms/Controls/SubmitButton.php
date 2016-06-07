<?php

namespace Forms\Controls;

use Utils\Html;

class SubmitButton extends BaseControl
{

    const TYPE = 'submit';

    /** @var Html */
    protected $element;

    /** @var Html*/
    protected $label;


    public function __construct($name, $label)
    {
        parent::__construct($name);

        $this->createElement($label);

    }


    private function createElement($buttonText)
    {
        $element = Html::el('button');

        $element->setAttribute('type', self::TYPE);
        $element->setAttribute('name', $this->name);
        $element->setText($buttonText);

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