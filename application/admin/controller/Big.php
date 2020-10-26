<?php
/**
 * User: 伍先生
 * DateTime: 2020/5/7 22:55
 * Class:  Big
 * Info: 大数据
 */

namespace app\admin\controller;


use think\Controller;

class Big extends Controller
{
    /**
     * Info: 中间总人数
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/8 9:38
     * Function:  api1
     */
    public function api1(){

        //总人数
        $people = db('student')->cache(001)->count('id');

        $sign = db('face_information')
            ->where("type",'<>',"99999" );


        $sign1 = $sign->where(['type'=>[1,2,3,4,5,6]])
                ->cache(001)->count('id');
        $sign2 = $sign->where(['type'=>[11,22,33,44,55,66]])
                ->cache(001)->count('id');
        $sign3 = db('face_information')
            ->where("type","99999" )
            ->cache(001)
            ->count("id");

        $data['A'] = $people;
        $data['B'] = $sign1;
        $data['C'] = $sign2;
        $data['D'] = $sign3;
        $data['E'] = db('face_information')->cache(001)->count("id");
        $this->result($data,1,"ok",'json');

    }


    /**
     * Info: 一周打卡情况
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/8 15:00
     * Function:  api2
     */
    public function api2(){
        $weekarray = array("周日", "周一", "周二", "周三", "周四", "周五", "周六");


        $date = date("Y-m-d");

        $data['w'][0] = $weekarray[date("w")];
        $data['z'][0] = db('face_information')->whereBetweenTime('addtime', $date)->where(['type'=>[1,2,3,4,5,6]])->cache(001)->count('id'); //正常打卡
        $data['c'][0] = db('face_information')->whereBetweenTime('addtime', $date)->where(['type'=>[11,22,33,44,55,66]])->cache(001)->count('id'); //迟到早退
        $data['q'][0] = db('face_information')->whereBetweenTime('addtime', $date)->where(['type'=>99999])->cache(001)->count('id'); //其他打卡


        for ($i = 1 ;$i< 7 ; $i++){

            $date = date("Y-m-d",strtotime("-$i  day"));

            $data['w'][$i] = $weekarray[date("w",strtotime("-$i  day"))];
            $data['z'][$i] = db('face_information')->whereBetweenTime('addtime', $date)->where(['type'=>[1,2,3,4,5,6]])->cache(001)->count('id'); //正常打卡
            $data['c'][$i] = db('face_information')->whereBetweenTime('addtime', $date)->where(['type'=>["11","22","33","44","55","66"]])->cache(001)->count('id'); //迟到早退
            $data['q'][$i] = db('face_information')->whereBetweenTime('addtime', $date)->where(['type'=>99999])->cache(001)->count('id'); //其他打卡
        }


        $this->result($data,1,'OK','json');
    }

    /**
     * Info: 一年打卡情况
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/8 15:01
     * Function:  api3
     */
    public function api3(){
        $data = [];
        for ($i = 0; $i < 12; $i++) {

            $date1 = date("Y-m", strtotime("-$i month"))."-01";
            $x = $i-1;
            $date2 = date("Y-m", strtotime("-$x month"))."-01";

            $data['y'][$i] = date("Y-m", strtotime("-$i month"));
            $data['z'][$i] = db('face_information')->where('addtime','between time',[$date1,$date2])->where(['type' => [1, 2, 3, 4, 5, 6]])->count('id');
            $data['c'][$i] = db('face_information')->where('addtime','between time',[$date1,$date2])->where(['type' => [11, 22, 33, 44, 55, 66]])->count('id');
            $data['q'][$i] = db('face_information')->where('addtime','between time',[$date1,$date2])->where(['type' => 99999])->count('id');

        }

        $this->result($data, 1, 'OK', 'json');
    }


    /**
     * Info: 进出口设备停机
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/8 20:34
     * Function:  api4
     */
    public function api4(){
        $data = [];

        $equipment1 = db("equipment")->where("turnover",1)->field('id,title,site')->cache(6)->select();
        foreach ($equipment1 as $key=>$val){
            $data['A']["title"][$key] = $val['site'];
            $data['A']["date"][$key]['name'] = $val['site'];
            $data['A']["date"][$key]['value'] = db('face_information')->where('serial_no',$val['title'])->cache(60)->count('id');
        }


        $equipment2 = db("equipment")->where("turnover",2)->field('id,title,site')->cache(1)->select();

        foreach ($equipment2 as $key=>$val){
            $data['B']["title"][$key] = $val['site'];
            $data['B']["date"][$key]['name'] = $val['site'];
            $data['B']["date"][$key]['value'] = db('face_information')->where('serial_no',$val['title'])->cache(60)->count('id');
        }


        $this->result($data, 1, 'OK', 'json');
    }

    /**
     * Info: 实时打卡数据
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/8 21:12
     * Function:  api5
     */
    public function api5(){

        $data = db('face_information')
            ->alias("f")
            ->join('jw_student s',"s.id=f.sid" )
            ->join('jw_grade g',"g.id=s.class_id" )
            ->field("name,f.addtime as addtime,g.title as title")
            ->order('f.addtime','desc')
            ->limit(20)
            ->cache(120)
            ->select();

        $this->result($data, 1, 'OK', 'json');

    }

    /**
     * Info: 班级的周 月排行
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/8 22:34
     * Function:  api6
     */
    public function api6(){


        $grade = db('grade')->where('type',1)->select();



        foreach ($grade as $key=>$val){

            $data['A'][$key]["n"] = $val['title'];

            $data['A'][$key]["y"] = $y1 = db('student')->where("class_id",$val['id'])->count('id');

            $data['A'][$key]["s"] = $s1= db('face_information')
                ->alias("f")
                ->join('jw_student s',"s.id=f.sid" )
                ->where('s.class_id',$val['id'])
                ->whereTime('f.addtime', 'week')
                ->where(['f.type'=>[1]])
                ->count("f.id");


            $data['B'][$key]["n"] = $val['title'];
            $data['B'][$key]["y"] = $y2 = db('student')->where("class_id",$val['id'])->count('id');
            $data['B'][$key]["s"] = $s2= db('face_information')
                ->alias("f")
                ->join('jw_student s',"s.id=f.sid" )
                ->where('s.class_id',$val['id'])
                ->whereTime('f.addtime', 'month')
                ->where(['f.type'=>[1]])
                ->count("f.id");


        }

        $sort_arr1 = [];
        foreach ($data["A"] as $key => $value) {
            $sort_arr1[] = $value['s'];
        }
        array_multisort($sort_arr1, SORT_DESC, $data["A"]);

        $sort_arr2 = [];
        foreach ($data["B"] as $key => $value) {
            $sort_arr2[] = $value['s'];
        }
        array_multisort($sort_arr2, SORT_DESC, $data["B"]);

        $this->result($data, 1, 'OK', 'json');

    }

    /**
     * Info: 当天上午出勤率
     * Argument :
     * User: 伍先生
     * DateTime: 2020/5/9 13:41
     * Function:  api7
     */
    public function api7(){
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
                ->where('f.type',1)
                ->whereTime('f.addtime', 'today')
                ->count('f.id');
        }


        $this->result($data, 1, 'OK', 'json');
    }
}