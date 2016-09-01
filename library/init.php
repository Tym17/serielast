<?php

if (DEVELOPMENT_ENVIRONMENT == true) {
    error_reporting(E_ALL);
    ini_set('display_errors','On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors','Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', ROOT.DS.'tmp'.DS.'error.log');
}




/*
** Call hook
*/
$urlArray = array();
$urlArray = explode("/",$url);

$controller = $urlArray[0];
array_shift($urlArray);

/*
** Define default function Callback
*/
$queryString;
if (!empty($urlArray))
{
    $action = $urlArray[0];
    if (!empty($urlArray))
    {
        array_shift($urlArray);
        $queryString = $urlArray;
    }
}
else
    $action = 'index';

$controllerName = $controller;
$controller = ucwords($controller);
$controller .= 'Controller';
if (class_exists($controller))
{
    $dispatch = new $controller($controllerName,$action);
    echo $controller . ', ' . $action;
    if ((int)method_exists($controller, $action))
    {
        call_user_func_array(array($dispatch,$action), $queryString);
    }
    else
    {
        if (USE_CONTROLLER_404)
        {
            /* Call 404 of the controller */
            call_user_func_array(array($dispatch,'noAction'), array($action));
        }
        else
        {
            /* Call 404 of the app */
            $dispatch = new error404Controller('error404', 'index');
            call_user_func_array(array($dispatch, 'index'), array($controller));
        }
    }
}
else
{
    /* Call 404 of the app */
    $dispatch = new error404Controller('error404', 'index');
    call_user_func_array(array($dispatch, 'index'), array($controller));
}
