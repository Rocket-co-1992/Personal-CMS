<?php
namespace Core;

class Router
{
    private $routes = [];
    
    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }
    
    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            $pattern = $this->convertRouteToRegex($route['path']);
            
            if (preg_match($pattern, $requestPath, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->executeHandler($route['handler'], $params);
                return;
            }
        }
        
        // Route not found
        header('HTTP/1.1 404 Not Found');
        echo '404 - Page not found';
    }
    
    private function convertRouteToRegex($route)
    {
        $pattern = preg_replace('/\/{([^\/]+)}/', '/(?P<$1>[^/]+)', $route);
        return '#^' . $pattern . '$#';
    }
    
    private function executeHandler($handler, $params)
    {
        list($controllerName, $methodName) = explode('@', $handler);
        $controllerClass = "\\Controllers\\$controllerName";
        
        $controller = new $controllerClass();
        call_user_func_array([$controller, $methodName], [$params]);
    }
}
