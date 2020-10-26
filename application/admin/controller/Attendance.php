<?php
/**
 * User: 伍先生
 * DateTime: 2020/3/19 22:56
 * Class:  Attendance
 * Info: 考勤设置
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class Attendance extends AdminBasic
{
    /**
     * Info: 考勤设置列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 23:20
     * Function:  GradeList
     */
    public function AttList(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $table = db('attendance');
            if(isset($postData['mark']) && $postData['mark'] !=null){
                $table->where('grade_id',$postData['mark']);
            }
            $userlist= $table
                ->alias('a')
                ->join('grade r','a.grade_id = r.id')
                ->limit($page,$limit)
                ->field('a.*,r.title')
                ->select();

            $count = $table->count();
            return $this->tableList(0,'成功',$userlist,$count);
        }
        $grade = db('grade')->where("type",2)->select();
        $this->assign('list',$grade);
        return $this->fetch();
    }

    /**
     * Info: 添加考勤设置
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 23:21
     * Function:  add
     */
    public function add(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));
            $id = db('attendance')->insertGetId($postData);
            //年级更新
            $bool = db('grade')->where("id",$postData['grade_id'])->update(['time_id'=>$id]);

            if($bool){
                $this->result('',1,'添加成功');
            }else{
                $this->result('',-1,'添加失败');
            }



        }
        $grade = db('grade')->where("type",2)->where("time_id",0)->select();
        $this->assign('list',$grade);

        return $this->fetch();
    }


    /**
     * Info: 考勤修改
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 21:06
     * Function:  edit
     */
    public function edit(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            if($postData['id'] > 0){
                $id = $postData['id'];
                //以前的更新为0
                db('grade')->where("time_id",$id)->update(['time_id'=>0]);
                //年级更新
                db('grade')->where("id",$postData['grade_id'])->update(['time_id'=>$id]);

                $bool = db('attendance')->where('id',$id)->update($postData);
                if($bool){
                    $this->result('',1,'更新成功');
                }else{
                    $this->result('',-1,'更新失败');
                }

            }else{
                $this->result('',-1,'参数错误');
            }

        }else{

            $id = input("id");
            $attendance = db('attendance')->where('id',$id)->find();
            $this->assign($attendance);

            $grade = db('grade')->where("type",2)->where("time_id",0)->whereOr("time_id",$attendance['id'])->select();
            $this->assign('list',$grade);
            return $this->fetch();
        }
    }


    /**
     * Info: 考勤删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 21:11
     * Function:  del
     */
    public function del(){
        $postData = input('post.');
        if($postData['id']>0){
            db('attendance')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }
}