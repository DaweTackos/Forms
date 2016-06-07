<?php

namespace Forms\Controls;

use Utils\Html;

class TextInput extends TextBase
{

    const TYPE = 'text';


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


    /**
     * Set value to element
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException(sprintf('Type must be string, %s given', gettype($type)));
        }
        $this->element->setAttribute('type', $type);

        return $this;
    }
}