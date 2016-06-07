<?php

namespace Forms;

use Forms\Controls;
use Forms\Renderer\FormRenderer;
use Forms\Renderer\IFormRenderer;
use Utils\Html;

/**
 * Create and render web forms.
 */
class Form
{

    /** @var Controls\ControlGroup[] */
    private $controls = [];

    /** @var Controls\ControlGroup[] */
    private $groups = [];

    /** @var Controls\ControlGroup */
    private $currentGroup;

    /** @var Html */
    private $element;

    /** @var IFormRenderer */
    private $renderer;

    /** @var string */
    private $method;

    /** @var string */
    private $action;

    /** @var string */
    private $name;


    public function __construct($name)
    {
        $this->method = 'post';
        $this->action = ''; //send to same script
        $this->name = $name;

        $this->createElement();
    }


    /**
     * Create html element and store in component.
     *
     * @return void
     */
    private function createElement()
    {
        $element = Html::el('form');
        $element->setAttribute('action', $this->action);
        $element->setAttribute('method', $this->method);
        $element->setAttribute('name', $this->name);
        $element->setAttribute('id', 'frm-' . $this->name);

        $this->element = $element;
    }


    /**
     * @return Html
     */
    public function getElement()
    {
        return $this->element;
    }


    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }


    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = htmlspecialchars($action);
        $this->element->setAttribute('action', $this->action);
    }


    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }


    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }


    /**
     * Add control to form. Check if control already exists.
     *
     * @param Controls\BaseControl $control
     *
     * @throw InvalidArgumentException
     */
    public function addControl($control)
    {
        $name = $control->getName();
        if (array_key_exists($name, $this->controls)){
            throw new \InvalidArgumentException(sprintf('Component with name \'%s\' already exists', $name));
        }

        if ($this->currentGroup !== null) {
            $groupName = $this->currentGroup->getOption('name');
            $control->getElement()
                        ->setAttribute('name', $groupName . '[' . $control->getName() . ']');
            $this->currentGroup->add($control);
        }

        $this->controls[$name] = $control;
    }


    /**
     * Unset control
     *
     * @param string $name
     */
    public function deleteControl($name)
    {
        unset($this->controls[$name]);
    }


    /**
     * Get all form controls
     *
     * @return Controls\BaseControl[]
     */
    public function getControls()
    {
        return $this->controls;
    }


    /**
     * Add text input to form.
     *
     * @param string      $name  name of element
     * @param string|null $label
     * @param string|null $size  width of input element
     *
     * @return Controls\TextInput
     */
    public function addText($name, $label = null, $size = null)
    {
        $control = new Controls\TextInput($name, $label, $size);
        $id = $this->element->getAttribute('id') . '-' . $name;
        $control->getElement()
                    ->setAttribute('id', $id);
        $control->getLabel()->setAttribute('for', $id);

        $this->addControl($control);

        return $control;
    }


    /**
     * Add textarea input to form.
     *
     * @param string      $name    name of element
     * @param string|null $label
     * @param string|null $columns number of columns
     * @param string|null $rows    number of rows
     *
     * @return Controls\TextArea
     */
    public function addTextArea($name, $label = null, $columns = null, $rows = null)
    {
        $control = new Controls\TextArea($name, $label, $columns, $rows);
        $id = $this->element->getAttribute('id') . '-' . $name;
        $control->getElement()
                    ->setAttribute('id', $id);
        $control->getLabel()->setAttribute('for', $id);
        $this->addControl($control);

        return $control;

    }


    /**
     * Add password input to form.
     *
     * @param string      $name  name of element
     * @param string|null $label
     * @param string|null $size  width of input element
     *
     * @return Controls\Password
     */
    public function addPassword($name, $label = null, $size = null)
    {
        $control = new Controls\Password($name, $label, $size);
        $id = $this->element->getAttribute('id') . '-' . $name;
        $control->getElement()
            ->setAttribute('id', $id);
        $control->getLabel()->setAttribute('for', $id);

        $this->addControl($control);

        return $control;
    }


    /**
     * Add submit button to form.
     *
     * @param string      $name  name of element
     * @param string|null $label
     *
     * @return Controls\SubmitButton
     */
    public function addSubmit($name, $label = null)
    {
        $control = new Controls\SubmitButton($name, $label);
        $id = $this->element->getAttribute('id') . '-' . $name;
        $control->getElement()
            ->setAttribute('id', $id);
        $control->getLabel()->setAttribute('for', $id);
        $this->addControl($control);

        return $control;
    }


    /**
     * Add file input to form.
     *
     * @param string      $name  name of element
     * @param string|null $label
     *
     * @return Controls\FileInput
     */
    public function addFile($name, $label = null)
    {
        $control = new Controls\FileInput($name, $label);
        $id = $this->element->getAttribute('id') . '-' . $name;
        $control->getElement()
            ->setAttribute('id', $id);
        $control->getLabel()->setAttribute('for', $id);
        $this->addControl($control);
        $this->getElement()
                ->setAttribute('enctype', 'multipart/form-data');

        return $control;
    }


    /**
     * Add checkbox input to form.
     *
     * @param string      $name  name of element
     * @param string|null $label
     *
     * @return Controls\Checkbox
     */
    public function addCheckbox($name, $label = null)
    {
        $control = new Controls\Checkbox($name, $label);
        $id = $this->element->getAttribute('id') . '-' . $name;
        $control->getElement()
            ->setAttribute('id', $id);
        $control->getLabel()->setAttribute('for', $id);
        $this->addControl($control);

        return $control;
    }


    /**
     * Add group to form. All input after this method will add in this group.
     *
     * @param string      $name  name of group witch display in received data
     * @param string|null $label label display for example in fieldset legend
     *
     * @return Controls\ControlGroup
     */
    public function addGroup($name, $label = null)
    {
        $group = new Controls\ControlGroup();

        $group->setOption('name', $name);
        $group->setOption('label', $label);
        $this->currentGroup = $group;
        $this->groups[$name] = $group;

        return $group;
    }


    /**
     * @return Controls\ControlGroup[]
     */
    public function getGroups()
    {
        return $this->groups;
    }


    /**
     * Clear pointer to current group. Next inputs will add without group.
     *
     * @return void
     */
    public function clearGroupPointer()
    {
        $this->currentGroup = null;
    }


    /**
     * Sets form renderer.
     *
     * @param  IFormRenderer $renderer
     *
     * @return self
     */
    public function setRenderer(IFormRenderer $renderer = NULL)
    {
        $this->renderer = $renderer;
        return $this;
    }


    /**
     * Returns form renderer.
     * @return IFormRenderer
     */
    public function getRenderer()
    {
        if ($this->renderer === null) {
            $this->renderer = new FormRenderer();
        }
        return $this->renderer;
    }


    /**
     * Render form.
     *
     * @return string
     */
    public function render()
    {
        echo $this->getRenderer()->render($this);
    }
}
