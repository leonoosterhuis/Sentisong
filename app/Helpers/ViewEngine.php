<?php

namespace App\Helpers;

function viewEngine($view, $data = [])
{
    $data['main'] = view($view, $data)->render();

    $data['assetsLinks'] = array('resources/css/home.scss');
    $rendered = view('global.global', $data);
    echo $rendered;
    exit();
}


function dashboardViewEngine($view, $data = [])
{
//    $data['main'] = view($view, $data)->render();
    $data['assetsLinks'] = array('resources/css/manage.scss', 'resources/css/table.scss');
    $rendered = view($view, $data);
    echo $rendered;
    exit();
}


function gameHostViewEngine($view, $data = [])
{
    $data['assetsLinks'] = array('resources/css/manage.scss', 'resources/css/table.scss');
    $rendered = view($view, $data);
    echo $rendered;
    exit();
}
