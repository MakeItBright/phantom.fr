<?php

function app(): \PhantomFramework\Application
{
    return \PhantomFramework\Application::$app;
}

function request(): \PhantomFramework\Request
{
    return app()->request;
}

function response(): \PhantomFramework\Response
{
    return app()->response;
}

function view($view = '', $data = [], $layout = ''): string|\PhantomFramework\View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }
    return app()->view;
}

function abort($error = '', $code = 404)
{
    response()->setResponseCode($code);
    echo view("errors/{$code}", ['error' => $error], false);
    die;
}

function base_url($path = ''): string
{
    return PATH . $path;
}