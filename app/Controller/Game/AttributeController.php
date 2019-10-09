<?php
declare(strict_types = 1);
namespace App\Controller\Game;

use App\Controller\AbstractController;
use Swoole\WebSocket\Server as WebSocketServer;
class AttributeController extends AbstractController
{
    static public function create(WebSocketServer $server,$request)
    {



        $server->push($request->fd,json_encode([
            'user' => $request->get['name'],
            'pass' => $request->get['password']
        ]));
    }
}
