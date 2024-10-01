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
        // Extract data variables for use in the view
        extract($data);

        // Path to the view file
        $view_file = VIEWS . "/{$view}.php";
        // Check if the view file exists
        if (is_file($view_file)) {
            // Start output buffering to capture the view content
            ob_start();
            require $view_file;
            $this->content = ob_get_clean();
        } else {
            // Abort if view file is not found
            abort("Not found view {$view_file}", 500);
        }

        // If no layout is specified (false), return the content immediately
        if (false === $layout) {
            return $this->content;
        }

        // Path to the layout file
        $layout_file_name = $layout ?: $this->layout;
        $layout_file = VIEWS . "/layouts/{$layout_file_name}.php";

        // Check if the layout file exists
        if (is_file($layout_file)) {
            // Start output buffering for the layout
            ob_start();
            require_once $layout_file;
            return ob_get_clean();
        } else {
            // Abort if layout file is not found
            abort("Not found layout {$layout_file}", 500);
        }

        return '';
    }
}
