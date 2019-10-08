<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Game\AttributeController;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{

    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
        //$server->push($frame->fd, 'Recv: ' . $frame->data);
        (new ActionController($server,$frame))->run();

    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        var_dump('closed');
    }

    public function onOpen(WebSocketServer $server, Request $request): void
    {
        call_user_func(['App\Controller\Game\AttributeController','create'],$server,$request);
        //$server->disconnect($request->fd,4001,'hehe');
        //$server->push($request->fd, json_encode($request->get));
    }
}