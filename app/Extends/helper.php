<?php
if(!function_exists('success')){
    function success($data = [],$msg = '操作成功',$code = 1000){
        $json = [];
        $json['code'] = is_int($data) ? $data : $code;;
        $json['data'] = is_array($data) || is_object($data) ? $data : [];
        $json['msg'] = is_array($data) || is_object($data) ? $msg : $data;
        return json_encode($json);
    }
}

if(!function_exists('fail')){
    function fail($data = [],$msg = '操作失败',$code = 2000){
        $json = [];
        $json['code'] = is_int($data) ? $data : $code;
        $json['data'] = is_array($data) || is_object($data) ? $data : [];
        $json['msg'] = is_array($data) || is_object($data) ? $msg : $data;
        return json_encode($json);
    }
}

if(!function_exists('toTree')){
    function toTree($data){
        $tree = [];
        if(!is_array($data))return false;
        foreach ($data as $item) {
            if (isset($data[$item['pid']])) {
                $data[$item['pid']]['children'][] = &$data[$item['id']];
            } else {
                $tree[] = &$data[$item['id']];
            }
        }
        return $tree;
    }
}
if(!function_exists('socketData')){
    /**
     * @param string $actions 动作
     * @param array $data 数据
     * @return string
     */
    function socketData($actions = '',$data = []){

        $jsonData = [
            'actions' => $actions,
            'data' => $data
        ];
        return json_encode($jsonData);
    }
}
