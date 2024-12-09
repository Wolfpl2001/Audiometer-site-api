<?php

namespace Core;

use Core\View;

class Framework
{
    use Router, UrlEngine, View;
    private $request;
    public static $routes = [];  // Ensure routes are statically stored and initialized

    public function __construct() {
        $this->request = new Request();
    }

    public static function get($uri, $controller, $method, $middleware = null) {
        self::$routes['GET'][$uri] = ['class' => $controller, 'method' => $method, 'middleware' => $middleware];
    }

    public static function post($uri, $controller, $method, $middleware = null) {
        self::$routes['POST'][$uri] = ['class' => $controller, 'method' => $method, 'middleware' => $middleware];
    }

    public function run() {
        try {
            $method = $this->method();
            $path = $this->normalizePath($this->path());
            $callable = $this->match($method, $path);

            if (!$callable) {
                throw new \Exception('Route not found', 404);
            }

            $class = "App\\Controllers\\" . $callable['class'];
            $this->handleCallable($class, $callable);
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function normalizePath($path) {
        // Normalize path to avoid trailing slash issues, handle root path specifically
        return rtrim($path, '/') ?: '/';
    }

    private function handleCallable($class, $callable) {
        if (!class_exists($class)) {
            throw new \Exception('Class does not exist: ' . $class, 500);
        }

        $controller = new $class();
        $method = $callable['method'];

        if (!method_exists($controller, $method)) {
            throw new \Exception("Method '$method' is not a valid method in class '$class'", 500);
        }

        // Execute middleware if specified
        if (isset($callable['middleware']) && $callable['middleware'] !== null) {
            call_user_func([$callable['middleware'], 'isAuthenticated']);
        }

        $controller->$method($this->request);
    }

    private function match($method, $url) {
        if (empty(self::$routes[$method])) {
            return false;
        }

        foreach (self::$routes[$method] as $uri => $call) {
            if ($url === $uri) {
                return $call;
            }
        }
        return false;
    }

    private function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function path() {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function handleException(\Exception $e) {
        $code = $e->getCode();
        $message = $e->getMessage();
        $method = $this->method();
        $path = $this->path();
        $trace = $e->getTraceAsString();

        http_response_code($code);
        echo "<h1>Error: {$code}</h1>";
        echo "<p>Message: {$message}</p>";
        echo "<p>Request Method: {$method}</p>";
        echo "<p>Request Path: {$path}</p>";
        echo "<pre>Stack Trace:\n{$trace}</pre>";
    }
}
