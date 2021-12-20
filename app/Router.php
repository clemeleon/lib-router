<?php

declare(strict_types=1);

namespace App;

use Exception;

class Router
{
    private array $methods = ['GET', 'POST', 'PUT', 'DELETE'];

    private array $routes = [];

    public function get(string $path, $handler): void
    {
        $this->setRoute("GET", $path, $handler);
    }

    public function post(string $path, $handler): void
    {
        $this->setRoute("POST", $path, $handler);
    }

    public function put(string $path, $handler): void
    {
        $this->setRoute("PUT", $path, $handler);
    }

    public function delete(string $path, $handler): void
    {
        $this->setRoute("DELETE", $path, $handler);
    }

    /**
     * @throws Exception
     */
    public function any(array $methods, string $path, $handler): void
    {
        foreach ($methods as $method) {
            $temp = strtoupper($method);
            if (!in_array($temp, $this->methods)) {
                throw new Exception("this $method is not allowed!");
            }
            $this->setRoute($temp, $path, $handler);
        }
    }

    /**
     * @throws Exception
     */
    public function all(string $path, $handler): void
    {
        foreach ($this->methods as $method) {
            if (!in_array($method, $this->methods)) {
                throw new Exception("this $method is not allowed!");
            }
            $this->setRoute($method, $path, $handler);
        }
    }

    private function setRoute(string $method, string $path, $handler)
    {
        $this->routes[$method] = [
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * @throws Exception
     */
    public function process()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $routes = $this->routes[$method] ?? [];
        $callback = null;
        foreach ($routes as $route){
            if($route['path'] === $requestPath){
                $callback = $route['handler'];
            };
        }

        if (is_null($callback)) {
            throw new Exception("Route not found!");
        }

        call_user_func_array($callback, [
            $_REQUEST
        ]);
    }
}