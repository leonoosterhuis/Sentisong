<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Request;

function dumps($variable)
{
    echo "<head><title>Dump Function</title></head>";
    echo "<pre>";
    print_r($variable);
    echo "<pre>";
    exit;
}

function activeMenu($uri = '') {
    $active = '';
    if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
        $active = 'active';
    }
    return $active;
}
