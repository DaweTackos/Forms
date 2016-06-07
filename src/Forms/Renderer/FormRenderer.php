<?php

namespace Forms\Renderer;

use Forms\Form;
use Utils\Html;

class FormRenderer implements IFormRenderer
{

    /** @var Form */
    protected $form;

    /** @var array wrappers for rendering */
    public $wrappers = [
        'controls' => [
          'container' => 'table',
        ],

        'control' => [
            'container' => 'td',
        ],

        'label' => [
            'container' => 'th',
        ],

        'pair' => [
            'container' => 'tr',
        ],

        'group' => [
            'container' => 'fieldset',
            'label'     => 'legend',
        ],
    ];


    public function render(Form $form)
    {
        if ($this->form !== $form) {
            $this->form = $form;
        }

        $s = '';

        $s .= $this->renderBegin();

        $s .= $this->renderBody();

        $s .= $this->renderEnd();

        echo $s;
    }


    public function renderBegin()
    {
        $element = $this->form->getElement();
        return $element->startTag();
    }


    public function renderBody()
    {
        $s = '';

        //render controls in groups
        foreach ($this->form->getGroups() as $group) {
            if (!$group->getControls()) {
                continue;
            }

            $controlsContainer = $this->getWrapper('controls container');
            foreach ($group->getControls() as $control) {
                $pair = $this->getWrapper('pair container');

                $label = $this->getWrapper('label container')->addChild($control->getLabel());
                $input = $this->getWrapper('control container')->addChild($control->getElement());

                $pair->addChild($label);
                $pair->addChild($input);

                $controlsContainer->addChild($pair);

                $this->form->deleteControl($control->getName());
            }

            $groupContainer = $this->getWrapper('group container')
                                     ->addChild($controlsContainer);

            if ($group->getOption('label') != null) {
                $legend = $this->getWrapper('group label')
                                    ->setText($group->getOption('label'));
                $groupContainer->addChild($legend);
            }

            $s .= $groupContainer->render();
        }

        //render rest of controls without group
        $controlsContainer = $this->getWrapper('controls container');
        foreach ($this->form->getControls() as $control) {

            $pair = $this->getWrapper('pair container');

            $label = $this->getWrapper('label container')->addChild($control->getLabel());
            $input = $this->getWrapper('control container')->addChild($control->getElement());
            $pair->addChild($label);
            $pair->addChild($input);

            $controlsContainer->addChild($pair);
        }

        $s .= $controlsContainer->render();

        return $s;
    }


    public function renderEnd()
    {
        $element = $this->form->getElement();
        return $element->endTag();
    }


    /**
     * @param  string
     * @return Html
     */
    protected function getWrapper($name)
    {
        $data = $this->getValue($name);
        return $data instanceof Html ? clone $data : Html::el($data);
    }


    /**
     * @param  string
     * @return string
     */
    protected function getValue($name)
    {
        $name = explode(' ', $name);
        $data = $this->wrappers[$name[0]][$name[1]];
        return $data;
    }
}