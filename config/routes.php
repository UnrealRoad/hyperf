<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::addRoute(['GET', 'POST', 'HEAD','OPTIONS'], '/login', 'App\Controller\AuthController@login');
Router::addRoute(['GET', 'POST', 'HEAD','OPTIONS'], '/register', 'App\Controller\AuthController@register');
Router::addRoute(['GET','OPTIONS'], '/getUserState', 'App\Controller\AuthController@getUserState');
################################################################
Router::addServer('ws',function(){
    Router::get('/','App\Controller\WebSocketController');
});
################################################################

Router::addGroup("/blog/",function(){
    Router::post('store','App\Controller\Blog\BlogController@store');
    Router::get('list','App\Controller\Blog\BlogController@index');
});
