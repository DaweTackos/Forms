<?php

namespace Forms\Controls;

use Utils\Html;


class TextArea extends TextBase
{

    /** @var \Utils\Html */
    protected $element;


    public function __construct($name, $label, $columns = null, $rows = null)
    {
        parent::__construct($name, $label);

        $this->createElement();

        !$columns ?: $this->element->setAttribute('cols', $columns);
        !$rows ?: $this->element->setAttribute('rows', $rows);
    }


    private function createElement()
    {
        $element = Html::el('textarea');
        $element->setAttribute('name', $this->name);

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
        $this->element->setText($value);

        return $this;
    }
}