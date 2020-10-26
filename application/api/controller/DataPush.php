<?php
/**
 * User: 伍先生
 * DateTime: 2020/4/27 22:32
 * Class:  DataPush
 * Info: 数据推送
 */

namespace app\api\controller;


use think\Controller;

class DataPush extends Controller
{
    //更新 websocket 数据
    public function upws()
    {
        $Data = input();
        $rule = [
            'pid' => 'require',
            'ip' => 'require',
            'port' => 'require',
        ];
        $validate = new \think\Validate;
        $validate->rule($rule);

        if (!$validate->check($Data)) {
            return $validate->getError();
        }

        $jsonArr['pid'] = $Data['pid'];
        $jsonArr['ip'] = $Data['ip'];
        $jsonArr['port'] = $Data['port'];
        $jsonArr['status'] = $Data['status']?$Data['status']:"未知";
        $jsonArr['time'] = date("Y-m-d H:i:s");

        $json = json_encode($jsonArr,256);

        $data = db('system')->where("title",'websocket')->update(['json'=>$json]);
        if($data){
            return "success";
        }else{
            return 'error';
        }

    }
    //系统断线/下线
    public function upwsclose()
    {
        $Data = input();
        $rule = [
            'pid' => 'require',
            'ip' => 'require',
            'port' => 'require',
        ];
        $validate = new \think\Validate;
        $validate->rule($rule);

        if (!$validate->check($Data)) {
            return $validate->getError();
        }

        $jsonArr['pid'] = $Data['pid'];
        $jsonArr['ip'] = $Data['ip'];
        $jsonArr['port'] = $Data['port'];
        $jsonArr['time'] = date("Y-m-d H:i:s");

        $json = json_encode($jsonArr,256);

        $data = db('system')->where("title",'websocket')->update(['json'=>$json]);
        if($data){
            return "success";
        }else{
            return 'error';
        }

    }

    /**
     * Info: 更新 或添加 新设备
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/3 18:38
     * Function:  updataequipment
     */
    public function updataequipment(){
        $Data = input();
        $rule = [
            'SerialNo' => 'require',
            'IP' => 'require',
            'ID' => 'require',
            'type' => 'require',
            'state' => 'require',
        ];
        $validate = new \think\Validate;
        $validate->rule($rule);

        if (!$validate->check($Data)) {
            return $validate->getError();
        }

        $jsonArr['title'] = $Data['SerialNo'];
        $jsonArr['device'] = $Data['IP'];
        $jsonArr['mark'] = $Data['ID'];
        $jsonArr['type'] = $Data['type'];
        $jsonArr['state'] = $Data['state'];
        $jsonArr['uptime'] = date("Y-m-d H:i:s");

        $equipment = db('equipment')->where("title",$Data['SerialNo'])->find();

        if($equipment){
            $bool = db('equipment')->where("title",$Data['SerialNo'])->update($jsonArr);
        }else{
            $jsonArr['addtime'] = date("Y-m-d H:i:s");
            $bool = db('equipment')->insert($jsonArr);
        }

        if($bool){
            return "success";
        }else{
            return 'error';
        }
    }

    /**
     * Info: 人像推送返回
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/3 21:21
     * Function:  getmsg
     */
    public function getmsg(){
        $Data = input();

        seveLog("STD_getmsg",json_encode($Data,256).PHP_EOL.PHP_EOL);

        /*
        if(isset($Data['params']['Code'])){

            $id = $Data['params']['Code'];






        }
        */

    }


}