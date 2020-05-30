<?php
namespace mvc;

class Dispatcher {

    private $router;

    function __construct() {
        $this->router = new Router();
    }

    public final function dispatch() {
        $this->router->route(
            $_SERVER['REQUEST_METHOD'],
            $this->pathFromUri($_SERVER['REQUEST_URI']),
            $_REQUEST);
    }

    public final function routing($pattern, $action) {
        $this->router->addRouting($pattern, $action);
        return $this;
    }

    private final function pathFromUri($path) {
        $path = !empty($path) && $path[strlen($path) - 1] == '/' ? substr($path, 0, strlen($path) - 1) : $path;
        if (empty($path)) {
            return '';
        }
        $queryPos = strpos($path, '?');
        if ($queryPos !== FALSE) {
            $path = substr($path, 0, $queryPos);
        }
        return $path[0] === '/' ? substr($path, 1) : $path;
    }
}

class Router {

    private $routing = [];

    public final function addRouting($pattern, $action) {
        $this->routing[$pattern] = $action;
    }

    public final function route($method, $path, $params) {
        $path = "{$method} " . $this->withEscapedSlashes("/{$path}");

        foreach ($this->routing as $pattern => $handler) {
            $patternParams = $this->patternParams($pattern);
            if (!empty($patternParams)) {
                $pattern = $this->withParams($pattern);
            }
            $pattern = $this->withEscapedSlashes($pattern);
            $pattern = $this->withMethod($pattern);

            if ($this->requestMatches($pattern, $path, $patternParams, $params)) {
                $handler($params);
                return;
            }
        }

        http_response_code(404);
        if (array_key_exists('/', $this->routing)) {
            $this->route['/']([]);
        }
    }

    private function requestMatches($pattern, $path, $patternParams, &$params) {
        if (preg_match("/^{$pattern}$/i", $path, $matches)) {
            for ($i = 0; $i < sizeof($patternParams); $i++) {
                $params[$patternParams[$i]] = $matches[$i + 1];
            }
            return true;
        }
        return false;
    }

    private function patternParams($pattern) {
        $matches = [];
        if (preg_match_all('/{(\w+)}/', $pattern, $matches)) {
            return $matches[1];
        }
    }

    private function withEscapedSlashes($pattern) {
        return str_replace('/', ':', $pattern);
    }

    private function withMethod($pattern) {
        return !preg_match("/^[A-Z]+ .+$/i", $pattern) ? "GET {$pattern}" : $pattern;
    }

    private function withParams($pattern) {
        return preg_replace('/{\w+}/', '([^:]+)', $pattern);
    }
}

