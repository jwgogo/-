<?php
/**
 * Created by PhpStorm.
 * User: 白衬衫
 * Date: 2019/7/12
 * Time: 15:30
 * Info: 说明
 */

//设置时区
ini_set('date.timezone','Asia/Shanghai');
require_once "Task.php";
include 'config.php';

class Ws extends Task
{

    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server( _HOST_, _PORT_);

        $this->ws->set(
            [
                'worker_num' => 4, //配置为CPU核数的1-4倍即可
                'task_worker_num' => 4,
                'daemonize' => 1,  //守护进程
                'log_file' => "/www/wwwroot/campus/swoole/log/" . date('Ymd') . ".log",
                'log_level' => SWOOLE_LOG_TRACE,
                'trace_flags' => SWOOLE_TRACE_SERVER | SWOOLE_TRACE_HTTP2,
            ]
        );

        $this->ws->on("start", [$this, 'onStart']);
        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("request", [$this, 'onRequest']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);

//        运行
        $this->ws->start();
    }


    /**
     * Info: 启动服务器
     * User: 白衬衫
     * Date: 2019/7/12
     * Time: 15:48
     */
    public function onStart($server)
    {


        $ip = _IP_;

        $pid = $server->master_pid;
        $this->echolog("onStart", "服务启动 PID: $pid  IP: $ip 端口: "._PORT_);
        swoole_set_process_name("SWOOLE_SID"); //修改进程名字


        //更新 websocket 数据
        $data['GENRE'] = 1;  //更新 websocket
        $data['pid'] = $pid;
        $data['ip'] = $ip;
        $data['port'] = _PORT_;
        $data['status'] =1;
        $this->ws->task($data);
    }

    /**
     * Info: 连接时触发 异步通道 1
     * User: 白衬衫
     * Date: 2019/7/12
     * Time: 16:00
     */
    public function onOpen($ws, $request)
    {

        //设备连接  入库更新
        $reData = $request->get;


        var_dump($reData);


        $this->echolog("onOpen", json_encode($request, 256) . "\n" . json_encode($reData, 256));

        if (isset($reData['SerialNo'])) {
            $data['GENRE'] = 2; //更新或添加连接设备信息
            //设备名
            $data['SerialNo'] = $reData['SerialNo'];
            //设备ID
            $data['ID'] = $request->fd;
            //设备IP
            $data['IP'] = $request->server['remote_addr'];
            $data['type'] = "人脸识别_STD";
            $data['state'] = 1;
            $this->ws->task($data);  //异步管道  1,2,3,4
        }


    }

    /**
     * Info: 发消息 异步通道随机 3/4
     * User: 白衬衫
     * Date: 2019/7/12
     * Time: 15:59
     */
    public function onMessage($ws, $frame)
    {
        if ($frame->data == "ping") {
            $ws->push($frame->fd, "pong");
        }else{
            $this->echolog("onMessage", json_encode($frame, 256));


            $frame = $this->transition($frame->data);
            $strArr = json_decode($frame,1);
            $strArr['GENRE'] = 3;
            $this->ws->task($strArr,2);
        }
    }


    //web通知下发  异步通道2
    public function onRequest($request, $response)
    {
        $this->echolog("onRequest", json_encode($request, 256) . "\n" . json_encode($response, 256));

        $getData = $request->get;
        $this->echolog("onRequest", json_encode($getData, 256) );
        //发送指定数据到设备
        if (isset($getData['fid'])) {

            //获取FID
            $fid = $getData['fid'];
            unset($getData['fid']);

            //转为json
            $dataStr = json_encode($getData,256);
            $this->ws->push($fid, $dataStr);

            $a = json_encode(["STATU" => "SUCCESS"]);
            $response->write($a);

            //重启操作 ?reload=66
        } elseif (isset($getData['reload']) && $getData['reload'] == 66) {
            $this->onReload();


            //接收到消息直接遍历到 各个 当前连接的设备上
        } elseif ($getData['method']){

            foreach ($this->ws->connection_list() as $fd) {

                if ($this->ws->isEstablished($fd)) {
                    $this->ws->push($fd,json_encode($getData,256));
                }

            }
            $a = json_encode(["STATU" => "SUCCESS"]);
            $response->write($a);
        }else {
            $a = json_encode(["Statu" => "Success"]);
            $response->write($a);
        }


    }

    public function onTask($ws, $taskId, $fromid, $data)
    {
        $this->echolog("onTask", json_encode($data, 256));
        //异步操作
        $task = new Task();

        switch ($data['GENRE']){
            case 1:
                $this->SetIpInfo($data);
                break;
            case 2:
                $this->SendAddUpdataEquipment($data);
                break;
            case 3:
                $this->SendInfo($data);
                break;
            case 4:
                break;
            default:
                $ws->finish('response');
        }

        //操作完执行
        $ws->finish('response');
    }


    public function onFinish($ws, $taskId, $data)
    {
        $this->echolog("onFinish", json_encode($data, 256));
    }


    /**
     * Info: 服务关闭
     * User: 白衬衫
     * Date: 2019/7/12
     * Time: 15:59
     */
    public function onClose($ws, $fd)
    {
        $this->echolog("onClose", "服务关闭 ID :  $fd");
    }


    /**
     * Info: 重启
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/2 0:14
     * Function:  onReload
     */
    public function onReload()
    {
        $this->echolog("onReload", "重起中...");
        $this->ws->reload();
    }






}

new Ws();