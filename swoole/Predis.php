<?php
/**
 * Created by PhpStorm.
 * User: 白衬衫
 * Date: 2019/7/12
 * Time: 15:41
 * Info: 说明
 */


class Predis
{
    public $redis = "";


    private static $_instance = null;

    public static function getInstance() {
        if(empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->redis = new \Redis();
        $result = $this->redis->connect('127.0.0.1');
        if($result === false) {
            throw new \Exception('redis connect error');
        }
    }



//    哈希存 用户信息 存一天 chatNum
    public function hSet($key,$val){

        if(!$key) {
            return '';
        }

        if(is_array($val)) {
            $val = json_encode($val);
        }

        $this->redis->hSet("chatNum",$key,$val);
        $data = json_decode($val,1);
        $this->redis->hSet("chatFd",$data['fd'],$data['user']);
    }

    //删除自己下线的人
    public function hDel($key){

        $data = $this->redis->hGet("chatFd",$key);
        $bool = $this->redis->hDel("chatNum",$data);
        if($bool){
            return true;
        }else{
            return false;
        }
    }


    //获取所有信息(聊天,用户)
    public function hGetAll($table){
        return $this->redis->hGetAll($table);
    }

    //保存聊天消息
    public function addChat($data){
        $key = date("Ymd");

        if(is_array($data)) {
            $data = json_encode($data);
        }
        $this->redis->rPush($key,$data);

    }

    //获取当天聊天信息
    public function getChatInfo(){
        $key = date("Ymd");
        return $this->redis->lRange($key,0,-1);
    }


//    public function __call($name, $arguments) {
//        //echo $name.PHP_EOL;
//        //print_r($arguments);
//        if(count($arguments) != 2) {
//            return '';
//        }
//        $this->redis->$name($arguments[0], $arguments[1]);
//    }
}

