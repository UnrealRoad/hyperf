<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Model\User;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Swoole\Http\Request;
use Swoole\WebSocket\Server as WebSocketServer;
class AuthController
{
    public function login(WebSocketServer $server, Request $request)
    {
        $username = $request->get['username'];
        $password = $request->get['password'];
        $userInfo = User::where('username',$username)->first();

        if($userInfo && $this->check($password,$userInfo->password)){
            $server->push($request->fd,json_encode([
                'action' => 'login',
                'data' => $userInfo
            ]));
        }else{
            $server->push($request->fd,json_encode([
                'action' => 'loginFail',
                'data' => [],
                'message' => '登录失败'
            ]));
            $server->disconnect($request->fd);
        }
    }

    public function register(WebSocketServer $server, Request $request)
    {
        $username = $request->get['username'];
        $password = $request->get['password'];
        $userInfo = User::create([
            'username' => $username,
            'password' => $this->hash($password)
        ]);

        if($userInfo){
            $server->push($request->fd,json_encode($request));
        }else{
            $server->push($request->fd,json_encode([
                'action' => 'registerFail',
                'data' => [],
                'message' => '注册失败'
            ]));
            $server->disconnect($request->fd);
        }

    }

    protected function hash($password){
        $hash = password_hash($password,PASSWORD_BCRYPT);
        if($hash === false){

        }
        return $hash;
    }

    protected function check($password,$hash){

        if (password_verify($password, $hash)) {
            // 使用户登录
            return true;
        }
        return false;
    }

}
