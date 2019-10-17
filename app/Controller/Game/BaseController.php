<?php

declare(strict_types = 1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use Hyperf\Utils\Context;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

/**
 * Class BaseController
 * @package App\Controller\Game
 *
 * @property  WebSocketServer $server
 * @property  Frame $frame
 */
class BaseController extends AbstractController
{

    public $test;
    public function __construct( WebSocketServer $server,Frame $frame)
    {
        $this->server = $server;
        $this->frame = $frame;
        $this->test = $frame;
    }

    public function push($action,$data)
    {
        $message = [
            'action' => $action,
            'data' => $data
        ];
        $this->server->push($this->frame->fd,json_encode($message));

    }

    public function __get($name)
    {
        return Context::get(__CLASS__ . ':' . $name);
    }

    public function __set($name, $value)
    {
        Context::set(__CLASS__ . ':' . $name,$value);
    }
}
