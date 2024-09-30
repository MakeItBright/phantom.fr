<?php

function app(): \PhantomFramework\Application
{
    return \PhantomFramework\Application::$app;
}

function request(): \PhantomFramework\Request
{
    return app()->request;
}