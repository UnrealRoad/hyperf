<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Swoole\Http\Request;
use Swoole\WebSocket\Server as WebSocketServer;

/**
 * Class AuthController
 * @package App\Controller
 *
 */
class AuthController
{
    /**
     * @param Request $request
     * @RequestMapping(path="/login",methods="get")
     */
    public function login( RequestInterface $request)
    {

        $data = $request->all();
        $username = $data['username'];
        $password = $data['password'];
        $userInfo = User::where('username',$username)->first();

        if($userInfo && $this->check($password,$userInfo->password)){
            return success([
                    'token' => JWT::getToken()
                ])
            ;
        }else{
            return fail();
        }
    }

    public function register(Request $request)
    {
        $username = $request->get['username'];
        $password = $request->get['password'];
        $userInfo = User::create([
            'username' => $username,
            'password' => $this->hash($password)
        ]);

        if($userInfo){
            return success($userInfo);
        }else{
            return fail();
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
