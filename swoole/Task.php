<?php
/**
 * Created by PhpStorm.
 * User: 白衬衫
 * Date: 2019/7/16
 * Time: 21:19
 * Info: 说明
 */

require_once 'Ws.php';
include 'config.php';


class Task
{

    /**
     * Info: 获取当前信息更新到客户端 方便用户操作
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/3 10:35
     * Function:  GetIpInfo
     */
    public function SetIpInfo($data)
    {
        $url = "Data_push/upws";
        $this->postJson($url, json_encode($data, 256));
    }

    /**
     * Info: 添加更新设备 到服务端
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/3 10:34
     * Function:  SendAddEquipment
     */
    public function SendAddUpdataEquipment($data)
    {
        $url = "Data_push/updataequipment";
        $this->postJson($url, json_encode($data, 256));
    }

    /**
     * Info: 客户端拿到信息发送到 设备
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/3 10:31
     * Function:  SendInfo
     */
    public function SendInfo($data)
    {
        $url = "Data_push/getmsg";
        $this->postJson($url, json_encode($data, 256));
    }

    /**
     * Info: 设备消息发送到 服务端
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/3 10:32
     * Function:  SendMsg
     */
    public function SendMsg()
    {

    }

    public function postJson($url, $data = null)
    {
        $url = _WEB_ . $url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $this->echolog("postJson", "请求url : " . $url . "\n参数: " . $data . "\n返回: " . $response);
    }

    /**
     * Info: 日志
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/2 0:47
     * Function:  echolog
     */
    public function echolog($func, $msg)
    {
        $date = date('Y-m-d H:i:s');
        echo "[$date # $func ] \n$msg \n\n";
    }


    /**
     * Info: 字符转json
     * User: 白衬衫
     * Date: 2019/7/14
     * Time: 18:48
     */
    public function transition($str)
    {
        $str = trim($str, '"');
        return $str;
    }

}