<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ApiException;
use App\Model\User;
use App\Traits\ApiResponse;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Swoole\Exception;


/**
 * Class AuthController
 * @package App\Controller
 *
 */
class AuthController
{
    use ApiResponse;
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
                'token' => JWT::getToken(['is_admin'=>$userInfo->is_admin])
                ])
            ;
        }else{
            return fail();
        }
    }

    public function register(RequestInterface $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

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

    public function getUserState(RequestInterface $request)
    {

        $token = $request->getHeader('authorization');
        if(!$token){
            return fail([],'请登录',2001);
        }
        list($token) = $token;
        $token = explode(' ',$token);
        list($bearer,$token) = $token;
        if(JWT::verifyToken($token)){
            return success();
        }
         return fail([],'请登录',2001);
    }
}
