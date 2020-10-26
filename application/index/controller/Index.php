<?php
namespace app\index\controller;

use app\jwcode\controller\Web;
use email\Email;
use email\PHPMailer;
use think\facade\Log;

class Index extends Web
{
    public function index()
    {
        $data = db('system')->where('title','website')->value('json');
        $this->assign('website',json_decode($data,1));
        return $this->fetch();
    }

    public function about(){
        $data = db('system')->where('title','website')->value('json');
        $this->assign('website',json_decode($data,1));
	    return $this->fetch();
    }

    public function log(){
        seveLog('测试日志信息',"jwcode");
        echo "OK";
    }
//
//    public function email()
//    {
//        $data = new Email();
//        $data->emailSend();
//    }
}
