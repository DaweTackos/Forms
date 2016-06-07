<?php

namespace Forms\Controls;

use Utils\Html;

/**
 * Base abstract class for form controls.
 */
abstract class BaseControl
{

    /** @var string */
    protected $name;

    /** @var mixed */
    protected $value;

    /** @var \Utils\Html */
    protected $label;

    /** @var \Utils\Html */
    protected $element;


    public function __construct($name, $label = null)
    {
        $this->setName($name);
        $this->setLabel($label);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        if ($name === null || $name === '' || !is_string($name)) {
            throw new \InvalidArgumentException(sprintf('Control name must be not empty string, %s given', $name));
        }
        $this->name = $name;

        return $this;
    }


    /**
     * @return Html
     */
    public function getLabel()
    {
        return $this->label;
    }


    /**
     * Create Html label element.
     *
     * @param string $label
     *
     * @return Html $element label element
     */
    public function setLabel($label)
    {
        $element = Html::el('label');
        $element->setText($label);

        $this->label = $element;

        return $element;
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
        $this->value = $value;
        return $this;
    }


    /**
     * Returns control's value.
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @return Html
     */
    public function getElement()
    {
        return $this->element;
    }


    /**
     * Set placeholder to element.
     *
     * @return self
     */
    public function setPlaceholder($text)
    {
        if (!is_string($text)) {
            throw new \InvalidArgumentException(sprintf('Placeholder must be string, %s given', gettype($text)));
        }
        $this->element->setAttribute('placeholder', $text);

        return $this;
    }


    /**
     * Set required parameter to element.
     *
     * @param bool $enable
     *
     * @return self
     */
    public function setRequired($enable = true)
    {
        if (!is_bool($enable)) {
            throw new \InvalidArgumentException(sprintf('Required must be boolean, %s given', gettype($enable)));
        }
        $this->element->setAttribute('required', $enable);

        return $this->element;
    }


    /**
     * Set disabled to element.
     *
     * @param bool $enable
     *
     * @return self
     */
    public function setDisabled($enable = true)
    {
        if (!is_bool($enable)) {
            throw new \InvalidArgumentException(sprintf('Required must be boolean, %s given', gettype($enable)));
        }

        $this->element->setAttribute('disabled', $enable);

        return $this;
    }

}
