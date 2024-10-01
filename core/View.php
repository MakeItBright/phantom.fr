<?php

namespace PhantomFramework;

class View
{

    public string $layout;
    public string $content = '';

    public function __construct($layout)
    {
        $this->layout = $layout;

    }

    public function render($view, $data = [], $layout = ''): string
    {
        dump($view.$data);
        return '';
    }

}