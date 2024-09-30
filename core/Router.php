<?php

namespace PhantomFramework;

class Router
{
    /**
     * Array of registered routes.
     *
     * @var array
     */
    protected array $routes = [];

    /**
     * Parameters extracted from the matched route.
     *
     * @var array
     */
    protected array $route_params = [];

    /**
     * Constructor for the Router class.
     *
     * @param Request $request The current HTTP request.
     * @param Response $response The response object to manage HTTP responses.
     */
    public function __construct(
        protected Request $request,
        protected Response $response
    )
    {
    }

    /**
     * Adds a route to the router with a given path, callback, and method.
     *
     * @param string $path The URL pattern for the route.
     * @param callable|array $callback The callback function or controller to handle the route.
     * @param string|array $method The HTTP method(s) for the route (e.g., 'GET', 'POST').
     *
     * @return self The current Router instance for method chaining.
     */
    public function add($path, $callback, $method): self
    {
        $path = trim($path, '/');
        if (is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
        }

        $this->routes[] = [
            'path' => "/$path",
            'callback' => $callback,
            'middleware' => null,
            'method' => $method,
        ];
        return $this;
    }

    /**
     * Adds a GET route.
     *
     * @param string $path The URL pattern for the GET route.
     * @param callable|array $callback The callback function or controller to handle the GET request.
     *
     * @return self The current Router instance for method chaining.
     */
    public function get($path, $callback): self
    {
        return $this->add($path, $callback, 'GET');
    }

    /**
     * Adds a POST route.
     *
     * @param string $path The URL pattern for the POST route.
     * @param callable|array $callback The callback function or controller to handle the POST request.
     *
     * @return self The current Router instance for method chaining.
     */
    public function post($path, $callback): self
    {
        return $this->add($path, $callback, 'POST');
    }

    /**
     * Returns all registered routes.
     *
     * @return array The array of registered routes.
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Dispatches the current request to the matching route.
     *
     * @return mixed The result of the route's callback or controller method.
     */
    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $route = $this->matchRoute($path);
        if (false === $route) {
            $this->response->setResponseCode(404);
            echo '404 - Page not found';
            die;
        }

        if (is_array($route['callback'])) {
            $route['callback'][0] = new $route['callback'][0];
        }

        return call_user_func($route['callback']);
    }

    /**
     * Matches the requested path against registered routes.
     *
     * @param string $path The current request path.
     *
     * @return array|false The matching route or false if no match is found.
     */
    protected function matchRoute($path): mixed
    {
        foreach ($this->routes as $route) {
            if (
                preg_match("#^{$route['path']}$#", "/{$path}", $matches)
                &&
                in_array($this->request->getMethod(), $route['method'])
            ) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $this->route_params[$k] = $v;
                    }
                }
                return $route;
            }
        }
        return false;
    }

}
