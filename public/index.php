<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';



/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'home', 'action' => 'index']);
$router->add('{controller}/', ['action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{id:\d+}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/', ['action' => 'index','namespace' => 'Admin']);
    
$router->dispatch($_SERVER['QUERY_STRING']);
