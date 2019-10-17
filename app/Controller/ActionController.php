<?php

declare(strict_types = 1);

namespace App\Controller;

use Hyperf\Config\Config;
use Hyperf\Utils\Context;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

/**
 * Class ActionController
 * @package App\Controller
 * @property WebSocketServer $server
 * @property Frame $frame
 * @property $action
 * @property $controller
 * @property $data
 * @property $routes
 */
class ActionController
{
    public function __construct(WebSocketServer $server, Frame $frame)
    {
        $this->server = $server;
        $this->frame = $frame;
        $this->routes = config('actions');
    }

    public function getAction()
    {
        $data = $this->frame->data;

        $value = is_string($data)  ? json_decode($data,true) : [];
        //var_dump($value);
        if(isset($value['action']) && array_key_exists($value['action'],$this->routes)){

            list($controller,$action) =  explode('@',$this->routes[$value['action']]);

            $this->action = $action;
            $this->controller = 'App\Controller\\' . $controller;
            $this->data = $value['data'];
        }
    }
    public function run()
    {
        $this->getAction();

        if($this->controller && $this->action){
            call_user_func([new $this->controller($this->server,$this->frame),$this->action],$this->data);
        }


        //$this->server->push($this->frame->fd, 'Recv: ' . $this->frame->data);
    }

    public function __get($name)
    {
        return Context::get(__CLASS__ . ':' .$name);
    }

    public function __set($name, $value)
    {
        Context::set(__CLASS__ . ':' .$name,$value);
    }
}
