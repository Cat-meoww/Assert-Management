<?php
if (!function_exists("nav_active")) {
    function nav_active(string $route)
    {
        $uri = service('uri');
        if ($uri->getPath() == $route) {
            return "active";
        }
        return " ";
    }
}
