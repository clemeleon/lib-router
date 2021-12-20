<?php

declare(strict_types=1);

namespace App;

class Router
{
    private array $handlers;
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';
    private const METHOD_PUT = 'PUT';
    private const METHOD_DELETE = 'DELETE';

    public function get(string $path, $handler): void
    {
        $this->useHandler(self::METHOD_GET, $path, $handler);
    }

    public function post(string $path, $handler): void
    {
    }

    public function put(string $path, $handler): void
    {
    }

    public function delete(string $path, $handler): void
    {
    }

    private function useHandler(string $method, string $path, $handler)
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function process()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callback = null;
        foreach ($this->handlers as $handler){
            if($handler['path'] === $requestPath && $method === $handler['method']){
                $callback = $handler['handler'];
            };
        }

        call_user_func_array($callback, [
            $_REQUEST
        ]);

        //var_dump($requestPath);
    }
}