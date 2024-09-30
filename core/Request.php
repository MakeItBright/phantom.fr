<?php

namespace PhantomFramework;

class Request
{
    /**
     * The request URI.
     *
     * @var string
     */
    public string $uri;

    /**
     * Constructor to initialize the request with the provided URI.
     *
     * @param string $uri The URI to be processed.
     */
    public function __construct($uri)
    {
        // Decode and trim slashes from the URI
        $this->uri = trim(urldecode($uri), "/");
    }

    /**
     * Get the HTTP method of the request.
     *
     * @return string The HTTP request method (GET, POST, etc.).
     */
    public function getMethod(): string
    {
        return strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    /**
     * Check if the request method is GET.
     *
     * @return bool True if the request method is GET, otherwise false.
     */
    public function isGet(): bool
    {
        return $this->getMethod() == 'GET';
    }

    /**
     * Check if the request method is POST.
     *
     * @return bool True if the request method is POST, otherwise false.
     */
    public function isPost(): bool
    {
        return $this->getMethod() == 'POST';
    }

    /**
     * Check if the request is an AJAX request.
     *
     * @return bool True if the request is an AJAX call, otherwise false.
     */
    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Retrieve a GET parameter.
     *
     * @param string $name The name of the GET parameter.
     * @param mixed $default The default value to return if the parameter is not set. Default is null.
     *
     * @return string|null The value of the GET parameter or the default value.
     */
    public function get($name, $default = null): ?string
    {
        return $_GET[$name] ?? $default;
    }

    /**
     * Retrieve a POST parameter.
     *
     * @param string $name The name of the POST parameter.
     * @param mixed $default The default value to return if the parameter is not set. Default is null.
     *
     * @return string|null The value of the POST parameter or the default value.
     */
    public function post($name, $default = null): ?string
    {
        return $_POST[$name] ?? $default;
    }

    /**
     * Get the request path without the query string.
     *
     * @return string The path of the request without query parameters.
     */
    public function getPath(): string
    {
        return $this->removeQueryString();
    }

    /**
     * Remove the query string from the URI and return the path.
     *
     * @return string The URI without the query string or an empty string if no URI is present.
     */
    protected function removeQueryString(): string
    {
        if ($this->uri) {
            $params = explode("?", $this->uri);
            return trim($params[0], '/');
        }
        return "";
    }
}
