<?php

declare(strict_types = 1);

namespace App\Controller;

use Hyperf\Config\Config;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

class ActionController
{
    public $server;
    public $frame;
    public $action;
    public $controller;
    public $data;

    public $routes;
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

}
