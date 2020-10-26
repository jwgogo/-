<?php
/**
 * User: 伍先生
 * DateTime: 2020/3/20 21:20
 * Class:  Dorm
 * Info:
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class Dorm extends AdminBasic
{

    /***************  宿舍类别  ******************/

    /**
     * Info: 宿舍类别 列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  Category
     */
    public function Category(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['id'=>'desc'];

            $table = db('category');

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
     * Info: 宿舍类别 添加
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  Category
     */
    public function CategoryAdd(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));
            $bool = db('category')->insert($postData);
            if($bool){
                $this->result('',1,'添加成功');
            }else{
                $this->result('',-1,'添加失败');
            }
        }
        return $this->fetch();
    }

    /**
     * Info: 宿舍类别 修改
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  Category
     */
    public function CategoryEdit(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            if($postData['id'] > 0){
                $id = $postData['id'];
                $bool = db('category')->where('id',$id)->update($postData);
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
            $data = db('category')->where('id',$id)->find();
            $this->assign($data);
            return $this->fetch();
        }
    }

    /**
     * Info: 宿舍类别 删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  Category
     */
    public function CategoryDel(){
        $postData = input('post.');
        if($postData['id']>0){
            db('category')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }


    /***************  宿舍楼栋  ******************/

    /**
     * Info: 宿舍楼栋 列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:34
     * Function:  building
     */
    public function building(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['id'=>'desc'];

            $table = db('building');

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
     * Info: 宿舍楼栋 添加
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:34
     * Function:  building
     */
    public function buildAdd(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));
            $bool = db('building')->insert($postData);
            if($bool){
                $this->result('',1,'添加成功');
            }else{
                $this->result('',-1,'添加失败');
            }
        }
        return $this->fetch();
    }

    /**
     * Info: 宿舍楼栋 修改
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  Category
     */
    public function buildEdit(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            if($postData['id'] > 0){
                $id = $postData['id'];
                $bool = db('building')->where('id',$id)->update($postData);
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
            $data = db('building')->where('id',$id)->find();
            $this->assign($data);
            return $this->fetch();
        }
    }

    /**
     * Info: 宿舍楼栋 删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:14
     * Function:  Category
     */
    public function buildDel(){
        $postData = input('post.');
        if($postData['id']>0){
            db('building')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }

    /***************  宿舍列表  ******************/

    /**
     * Info:  宿舍 列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 22:59
     * Function:  dormList
     */
    public function dormList(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['a.id'=>'desc'];

            $table = db('dorm');

            $userlist= $table
                ->alias('a')
                ->join('building b','a.b_id = b.id')  //宿舍楼栋
                ->join('category c','a.c_id = c.id')  //宿舍类别
                ->limit($page,$limit)
                ->field('a.*,b_title,c_title')
                ->order($order)
                ->select();

            $count = $table->count();
            return $this->tableList(0,'成功',$userlist,$count);
        }
        return $this->fetch();
    }

    /**
     * Info: 宿舍 添加
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 23:00
     * Function:  dormAdd
     */
    public function dormAdd(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));
            $bool = db('dorm')->insert($postData);
            if($bool){
                $this->result('',1,'添加成功');
            }else{
                $this->result('',-1,'添加失败');
            }
        }
        //宿舍类别
        $category = db('category')->select();
        $this->assign("category",$category);
        //宿舍楼栋
        $building = db('building')->select();
        $this->assign("building",$building);
        return $this->fetch();
    }


    /**
     * Info: 宿舍 修改
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 23:00
     * Function:  dormAdd
     */
    public function dormEdit(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            if($postData['id'] > 0){
                $id = $postData['id'];
                $bool = db('dorm')->where('id',$id)->update($postData);
                if($bool){
                    $this->result('',1,'更新成功');
                }else{
                    $this->result('',-1,'更新失败');
                }

            }else{
                $this->result('',-1,'参数错误');
            }

        }else{

            //宿舍类别
            $category = db('category')->select();
            $this->assign("category",$category);
            //宿舍楼栋
            $building = db('building')->select();
            $this->assign("building",$building);

            $id = input("id");
            $data = db('dorm')->where('id',$id)->find();
            $this->assign($data);
            return $this->fetch();
        }
    }

    /**
     * Info: 宿舍 删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/20 23:00
     * Function:  dormAdd
     */
    public function dormDel(){
        $postData = input('post.id');
        if($postData['id']>0){
            db('dorm')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }


    /***************  床位管理  ******************/



}