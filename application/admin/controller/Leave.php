<?php
/**
 * User: 伍先生
 * DateTime: 2020/3/21 21:58
 * Class:  Leave
 * Info: 请假操作
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class Leave extends AdminBasic
{

    /**
     * Info: 请假操作 列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  lists
     */
    public function lists(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['a.id'=>'desc'];

            $table = db('leave')
                ->alias('a')
                ->join('student s', 'a.s_id = s.id')
                ->field('a.*,name,school');
            $userlist= $table
                ->limit($page,$limit)
                ->order($order)
                ->select();

            $count = $table->count();
            return $this->tableList(0,'成功',$userlist,$count);
        }
        return $this->fetch();
    }

    /**
     * Info: 请假操作 添加
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  add
     */
    public function add(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));
            $bool = db('Leave')->insert($postData);
            if($bool){
                $this->result('',1,'添加成功');
            }else{
                $this->result('',-1,'添加失败');
            }
        }

        $id = input("id");
        $student = db('student')->where('id',$id)->find();
        $this->assign("student",$student);
        return $this->fetch();
    }

    /**
     * Info: 请假操作 修改
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  edit
     */
    public function edit(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            if($postData['id'] > 0){
                $id = $postData['id'];
                $bool = db('Leave')->where('id',$id)->update($postData);
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
            $data = db('Leave')->where('id',$id)->find();
            $this->assign($data);

            $student = db('student')->where('id',$data['s_id'])->find();
            $this->assign("student",$student);

            return $this->fetch();
        }
    }

    /**
     * Info: 请假操作 删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  del
     */
    public function del(){
        $postData = input('post.');
        if($postData['id']>0){
            db('Leave')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }
}