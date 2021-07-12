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

if (!function_exists('guardian')) {
    /**
     * Get guardian config
     *
     * @param string $target
     *
     * @return mixed
     */
    function guardian(string $target)
    {
        return config("guardian.{$target}");
    }
}


if (!function_exists('guardian_upsert')) {
    /**
     * Get guardian's upsert config
     *
     * @param string $target
     *
     * @return mixed
     */
    function guardian_upsert(string $target)
    {
        return config("guardian.guardian.upsert.{$target}");
    }
}
