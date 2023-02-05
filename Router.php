<?php

class Router
{
    // Router
    protected static array $router = [];

    // Prefix
    protected static string|null $prefix = null;

    /**
     * Grouping routes using a prefix
     * @return void
     */
    public static function group($prefix, $handler): void
    {
        self::$prefix = self::$prefix . $prefix;
        call_user_func($handler);
        self::$prefix = null;
    }

    /**
     * Get request routes
     * @return void
     */
    public static function get($uri, $handler): void
    {
        if (!empty(self::$prefix)) {
            $uri = self::$prefix . $uri;
        }

        if ($uri != "/") {
            $uri = rtrim($uri, "/");
        }

        self::$router['get'][$uri] = $handler;
    }

    /**
     * Post request routes
     * @return void
     */
    public static function post($uri, $handler): void
    {
        if (!empty(self::$prefix)) {
            $uri = self::$prefix . $uri;
        }

        if ($uri != "/") {
            $uri = rtrim($uri, "/");
        }

        self::$router['post'][$uri] = $handler;
    }


    /**
     * Request method
     * @return string
     */
    public static function method(): string
    {
        return strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD'));
    }

    /**
     * Request uri
     * @return mixed|string
     */
    public static function uri(): string
    {
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

        $position = strpos($uri, '?');

        if ($position) {
            $uri = substr($uri, 0, $position);
        }

        $uri = rtrim($uri, '/');

        $uri = (empty($uri)) ? "/" : $uri;

        return $uri;
    }


    /**
     * Router /router/add/{:id}/insert/{:insert}
     * @return mixed|string
     */
    public static function run()
    {
        $method = Router::method();

        $uri = Router::uri();

        if (is_array(self::$router[$method])) {

            foreach (self::$router[$method] as $pattern => $handler) {

                $arguments = [];

                preg_match_all("#\{:(.+?)\}#", $pattern, $list);

                $pattern = str_replace(['{:', '}'], ['(?<', '>\w+)'], $pattern);

                if (preg_match("#^" . $pattern . "$#i", $uri, $matches)) {

                    if (is_array($list[1])) {
                    
                        foreach ($list[1] as $item) {
                            $arguments[$item] = $matches[$item];
                        }
                        
                    }

                    return call_user_func_array($handler, $arguments);
                }
            }
        }

        return "Error 404";
    }


}
