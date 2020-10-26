<?php
/**
 * User: 伍先生
 * DateTime: 2020/3/18 23:16
 * Class:  Grade
 * Info: 年级/班级管理
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class Grade extends AdminBasic
{
    /**
     * Info: 班级列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 23:20
     * Function:  GradeList
     */
    public function GradeList(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['id'=>'desc','uptime'=>'desc'];
            if(input('?field') && input('?order')){
                $order = [$postData['field']=>$postData['order']];
            }

            $table = db('grade');

            if(isset($postData['title'])){
                $table->where('title','like','%'.$postData['title'].'%');
            }

            if(isset($postData['select'])){
                $table->where('type',$postData['select']);
            }

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
     * Info: 添加班级/年级
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 23:21
     * Function:  add
     */
    public function add(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            $rule =   [
                'type|类型'  => 'require',
                'title|名称'   => 'require',
            ];
            $validate = new \think\Validate;
            $validate->rule($rule);

            if (!$validate->check($postData)) {
                $this->result('',-1,$validate->getError());
            }


            $inertData['type'] = $postData['type'];
            $inertData['title'] = $postData['title'];


            $inertData['addtime'] = $inertData['uptime'] = date("Y-m-d H:i:s");

            $bool = db('grade')->insert($inertData);

            if($bool){
                $this->result('',1,'设备添加成功');
            }else{
                $this->result('',-1,'设备添加失败');
            }



        }
        return $this->fetch();
    }


    /**
     * Info: 班级修改
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 21:06
     * Function:  edit
     */
    public function edit(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            if($postData['id'] > 0){

                $rule =   [
                    'type|类型'  => 'require',
                    'title|名称'   => 'require',
                ];
                $validate = new \think\Validate;
                $validate->rule($rule);

                if (!$validate->check($postData)) {
                    $this->result('',-1,$validate->getError());
                }


                $inertData['type'] = $postData['type'];
                $inertData['title'] = $postData['title'];
                $updata['uptime'] = date("Y-m-d H:i:s");

                $bool = db('grade')->where('id',$postData['id'])->update($updata);
                if($bool){
                    $this->result('',1,'更新成功');
                }else{
                    $this->result('',-1,'更新失败');
                }

            }else{
                $this->result('',-1,'参数错误');
            }

        }else{
            $id = input('id');
            $equipment = db('grade')->where('id',$id)->find();
            $this->assign($equipment);
            return $this->fetch();
        }
    }


    /**
     * Info: 班级删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 21:11
     * Function:  del
     */
    public function del(){
        $postData = input('post.');
        if($postData['id']>0){
            db('grade')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }
}