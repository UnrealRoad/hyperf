<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Game\AttributeController;
use App\Controller\Game\AuthController;
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
        $server->push($frame->fd, json_encode($frame));
        $token = '';
        JWT::verifyToken($token);
        (new ActionController($server,$frame))->run();

    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        //var_dump('closed');
    }

    public function onOpen(WebSocketServer $server, Request $request): void
    {
        //
        $token = $request->header['sec-websocket-protocol'];

        if($token){
            if(JWT::verifyToken($token)){
                $server->push($request->fd, 'success');
            }else{
                $server->disconnect($request->fd);
            }
        }else{
            $server->disconnect($request->fd);
        }

    }
}
