<?php

namespace Forms\Renderer;


use Forms\Form;

interface IFormRenderer
{

    /**
     * Render form.
     *
     * @return string
     */
    public function render(Form $form);

}
