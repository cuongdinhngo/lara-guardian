<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('getPageAndAction')) {
    /**
     * Get Page and Action by RouteName
     *
     * @return array [$page, $action]
     */
    function getPageAndAction()
    {
        return explode('.', Route::currentRouteName());
    }
}
