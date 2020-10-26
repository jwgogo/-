<?php
/**
 * User: 伍先生
 * DateTime: 2020/5/4 15:20
 * Class:  PushFacility
 * Info:
 */

namespace app\api\controller;


use think\Controller;

class PushFacility extends Controller
{

    /**
     * Info: 获取设备信息
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/4 15:25
     * Function:  getWs
     */
    public function getWs()
    {
        $data = db('system')->where("title", 'websocket')->value('json');
        return json_decode($data, 1);
    }


    /**
     * Info: 批量
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/9 23:38
     * Function:  Batch
     */
    public function Batch(){
        $dataArr = input();


        $ok = 0;
        $no = 0;
        foreach ($dataArr as $key=>$data){
            $code = $this->pushws($data);
            if($code == 1){
                $ok++;
            }else{
                $no++;
            }
        }

        $msg['ok'] = $ok;
        $msg['no'] = $no;

            $this->result($msg,1,'成功','json');
    }

    /**
     * Info: 一个推送
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/9 23:37
     * Function:  datainfo
     */
    public function datainfo(){
        $data = input();

        $code = $this->pushws($data);
        if($code == 1){
            $this->result("",1,'成功','json');
        }else{
            $this->result("",2,'失败','json');
        }

    }


    public function pushws($data)
    {

        //中间服务器信息
        $ws = $this->getWs();
        $url = 'http://' . $ws['ip'] . ":" . $ws['port'];


        $imgurl = 'http://' . $_SERVER['HTTP_HOST'].$data['photo'];
        $Code = $data['id'];
        $Name = $data['name'];
        $Sex = $data['sex'] == 1 ? "male" : "woman";

        $json = '
{
    "id":99 ,
    "method":"personnelData.savePersons",
    "params":
    [
        {
            "Person":
                {
                    "Type": 1,
                    "Code": "' . $Code . '",
                    "GroupName": "默认权限组",
                    "Name": "' . $Name . '",
                    "Sex": "' . $Sex . '",
                    "Birthday": "2020-01-01",
                    "URL": ["' . $imgurl . '"],
                    "Cards":[{
                        "ID":"10001",
                        "Type": 1,
                        "Validity": ["2020-04-01","2029-10-01"],
                        "ValidityTime": ["00:00:00","23:59:59"]
                    }]
                }
        }
    ]
}';
        $request =   http_build_query(json_decode($json,1));

//        echo $url."?".$request;die;

        $statu = file_get_contents($url."?".$request);

//        $statu = $this->postJson($url,json_decode($json,1));
        $statuArr = json_decode($statu,1);


        if(isset($statuArr['STATU']) && $statuArr['STATU'] == "SUCCESS"){
            return 1;
        }else{
            return 2;
        }


    }

    public function postJson($url, $data = null)
    {
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
        return $response;
    }
}

