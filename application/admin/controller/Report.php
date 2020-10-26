<?php
/**
 * User: 伍先生
 * DateTime: 2020/3/20 23:33
 * Class:  Report
 * Info: 报表管理
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class Report extends AdminBasic
{
    /**
     * Info: 学生考勤
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 23:34
     * Function:  attendance
     */
    public function attendance(){
        return $this->fetch();
    }

    /**
     * Info: 打卡明细
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 23:34
     * Function:  attendance
     */
    public function details(){

        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['f.id'=>'desc','f.addtime'=>'desc'];

            $table = db('face_information');

            if(isset($postData['title'])){
                $table->where('s.name','like','%'.$postData['title'].'%');
            }

            if(isset($postData['site'])){
                $table->where('e.site','like','%'.$postData['site'].'%');
            }

            if(isset($postData['start'])){
                if($postData['start'] != '' && $postData['end'] != ''){
                    $start = $postData['start'];
                    $end = strtotime($postData['end'])+86399;
                    $table->whereTime('f.addtime', 'between', [$start, $end]);
                }

                if($postData['start'] != '' && $postData['end'] == ''){
                    $start = $postData['start'];
                    $end = time()+86399;
                    $table->whereTime('f.addtime', 'between', [$start, $end]);
                }

                if($postData['start'] == '' && $postData['end'] != ''){
                    $start = 0;
                    $end = $postData['end'];
                    $table->whereTime('f.addtime', 'between', [$start, $end]);
                }


            }
            $cache = json_encode($postData,256);

            $userlist= $table
                ->alias("f")
                ->join('jw_equipment e',"e.title=f.serial_no" ,'left')
                ->join('jw_student s',"s.id=f.sid" ,'left')
                ->limit($page,$limit)
                ->order($order)
                ->cache($cache,300)
                ->field("s.name as name,e.title as title, e.site as site, f.*")
                ->select();

            $count = db('face_information')->count('id');
            return $this->tableList(0,'成功',$userlist,$count);
        }
        return $this->fetch();

    }
    public function detailsDel(){
        $postData = input('post.');
        if($postData['id']>0){
            db('face_information')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');

    }


    /**
     * Info: 宿舍打卡
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 23:35
     * Function:  dorm
     */
    public function dorm(){
        return $this->fetch();
    }


}