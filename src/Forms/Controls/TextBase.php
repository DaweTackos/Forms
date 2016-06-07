<?php

namespace Forms\Controls;

/**
 * Abstract class for text controls.
 */
abstract class TextBase extends BaseControl
{

    /** @var integer */
    protected $maxLength;


    public function __construct($name, $label)
    {
        parent::__construct($name, $label);
    }


    /**
     * Set max length of text element.
     *
     * @param  int|string $length
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setMaxLength($length)
    {
        if (!is_numeric($length)){
            throw new \InvalidArgumentException(sprintf('Type must be numeric value, %s given with value %s', gettype($length), $length));
        }
        $this->element->setAttribute('maxlength',  $length);
        $this->maxLength = (int) $length;

        return $this;
    }


    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }


}
