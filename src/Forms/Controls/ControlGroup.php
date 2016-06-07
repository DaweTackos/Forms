<?php

namespace Forms\Controls;

/**
 * Create web form groups and add controls in them.
 */
class ControlGroup
{

    /** @var BaseControl[] */
    private $controls = [];

    /** @var array */
    private $options = [];


    public function __construct(){}


    /**
     * Add control to group.
     *
     * @param BaseControl $control
     *
     * @return self
     */
    public function add(BaseControl $control)
    {
        $this->controls[$control->getName()] = $control;

        return $this;
    }


    /**
     * Sets user-specific option.
     * Options recognized by FormRenderer
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function setOption($key, $value)
    {
        if ($value === NULL) {
            unset($this->options[$key]);
        } else {
            $this->options[$key] = $value;
        }

        return $this;
    }


    /**
     * Returns user-specific option.
     *
     * @param  string $key
     * @param  mixed  $default value
     *
     * @return mixed
     */
    public function getOption($key, $default = NULL)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }


    /**
     * Returns user-specific options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Returns controls belong to group.
     *
     * @return BaseControl[]
     */
    public function getControls()
    {
        return $this->controls;
    }
}
