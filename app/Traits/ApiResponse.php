<?php


namespace App\Traits;


use App\Exception\ApiException;

trait ApiResponse
{

    public function success($data = [],$code = HTTP_CODE_OK)
    {
        $data = is_object($data) || is_array($data) ? json_encode($data) : $data;
         throw new ApiException($data,$code);
    }

    public function fail($data = '123',$code = INTERNAL_SERVER_ERROR)
    {

        $data = is_object($data) || is_array($data) ? json_encode($data) : $data;

        throw new ApiException($data,$code);
    }
}
