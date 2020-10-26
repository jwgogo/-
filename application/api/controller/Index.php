<?php
/**
 * User: 伍先生
 * DateTime: 2020/4/23 23:12
 * Class:  Index
 * Info:
 */

namespace app\api\controller;


use think\Controller;
use think\facade\Env;

class Index extends Controller
{
    // STD 人脸型号 反向注册地址
    public function index()
    {


        $data = input();
        seveLog("STD", json_encode($data, 256) . PHP_EOL . PHP_EOL);
        seveLog("STD", $data['json'] . PHP_EOL . PHP_EOL);
        $jsonArr = json_decode($data['json'], 1);
        $Events = $jsonArr['Events'][0];

        if (isset($Events['Code']) && $Events['Code'] == "EventFaceRecognizeCutout") {
            $inserData['serial_no'] = $data['SerialNo'];
            $inserData['sid'] = isset($Events['RecognizeResults'][0]['PersonInfo']['ID'])?$Events['RecognizeResults'][0]['PersonInfo']['ID']:0;
            $inserData['picture'] = "data:image/png;base64," . $data['picture'];
            $inserData['addtime'] = date("Y-m-d H:i:s");
            $this->information($inserData);
        } else {
            echo "66";
        }

    }

    /**
     * Info: 添加数据到打卡表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/7 1:01
     * Function:  information
     */
    public function information($data)
    {


        $type = $this->gettype($data);


        $information = db('face_information')
            ->whereTime('addtime', 'today')
            ->where("type", $type)
            ->cache($data['sid'] . "$type" . date("Y-m-d"))
            ->find();

        if (!$information && $type != 99999) {
            $data['type'] = $type;
            db('face_information')->insert($data);
        } else {
            db('face_information')->insert($data);
        }


    }


    //判断打卡类型
    public function gettype($data)
    {


        //学生考勤时间
        $attendance = db('student')
            ->alias('s')
            ->join('jw_attendance a', 'a.grade_id = s.grade_id')
            ->where("s.id", $data['sid'])
            ->field('a.*')
            ->find();


        //设备作用
        $equipment = db('equipment')
            ->where("title", $data['serial_no'])
            ->where("signin", 1)
            ->find();


        if ($attendance && $equipment) {

            $time = strtotime(date("H:i:s"));

            //早上打卡时间
            $amtime1 = strtotime($attendance['amtime1']) + $attendance['amtime2'] * 60;
            $amtime3 = strtotime($attendance['amtime3']) + $attendance['amtime4'] * 60;

            //中午
            $pmtime1 = strtotime($attendance['pmtime1']) + $attendance['pmtime2'] * 60;
            $pmtime3 = strtotime($attendance['pmtime3']) + $attendance['pmtime4'] * 60;

            //晚上
            $ngtime1 = strtotime($attendance['ngtime1']) + $attendance['ngtime2'] * 60;
            $ngtime3 = strtotime($attendance['ngtime3']) + $attendance['ngtime4'] * 60;


            //进
            if ($equipment['turnover'] == 1) {

                if ($time > $amtime1 && $time < $amtime3) {
                    return 11; //迟到
                }

                if ($time < $amtime1) {
                    return 1;
                }

                if ($time > $pmtime1 && $time < $pmtime3) {
                    return 22; //迟到
                }

                if ($time < $pmtime1 && $time > $amtime3) {
                    return 2;
                }

                if ($time > $ngtime1 && $time < $ngtime3) {
                    return 33; //迟到
                }

                if ($time < $ngtime1 && $time > $pmtime3) {
                    return 3;
                }


                //出
            } else {

                if ($time > $amtime1 && $time < $amtime3) {
                    return 44; //早退
                }

                if ($time > $amtime3 && $pmtime1 > $time) {
                    return 4;
                }

                if ($time > $pmtime1 && $time < $pmtime3) {
                    return 55; //早退
                }

                if ($time > $pmtime3 && $time < $ngtime1) {
                    return 5;
                }

                if ($time > $ngtime1 && $time < $ngtime3) {
                    return 66; //早退
                }

                if ($time > $ngtime3) {
                    return 6;
                }


            }


        } else {
            return '99999';
        }


    }

    public function test()
    {

        //班级人数
        //早上打卡人数
        //百分比


        $grade = db('grade')->where('type',1)->select();

        $data = [];
        foreach ($grade as $key => $val){

            $data['b'][$key] = $val['title'];
            $data['n'][$key] = $n = db('student')->where('class_id',$val['id'])->count('id');
            $data['s'][$key] = $s = (int)db('face_information')
                ->alias("f")
                ->join('jw_student s',"s.id=f.sid" )
                ->join('jw_grade g',"g.id=s.class_id" )
                ->where('class_id',$val['id'])
                ->whereTime('f.addtime', 'today')
                ->count('f.id');
        }


        $this->result($data, 1, 'OK', 'json');

    }

    public function aaa()
    {
    }

}


