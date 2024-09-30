<?php

namespace PhantomFramework;

class Response
{
    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }


    public function redirect()
    {
        echo "Redirect";
    }
}