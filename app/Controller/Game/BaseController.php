<?php

declare(strict_types = 1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;
class BaseController extends AbstractController
{
    public $server;
    public $frame;
    public function __construct( WebSocketServer $server,Frame $frame)
    {
        $this->server = $server;
        $this->frame = $frame;
    }

}
