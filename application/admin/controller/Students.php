<?php
/**
 * User: 伍先生
 * DateTime: 2020/3/20 23:57
 * Class:  Students
 * Info:  学生管理
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class Students extends AdminBasic
{
    /**
     * Info: 学生列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/21 22:39
     * Function:  lists
     */
    public function lists()
    {
        if ($this->request->post()) {
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            if (input('?page') && input('?limit')) {
                $page = ($postData['page'] - 1) * 10;
                $limit = $postData['limit'];
            }

            $order = ['a.id' => 'desc'];


            $table = db('student')
                ->alias('a')
                ->join('grade g1', 'a.grade_id = g1.id')
                ->leftJoin('grade g2', 'a.class_id = g2.id')
                ->field('a.*,g1.title as grade,g2.title as class');

            if (isset($postData['grade']) && $postData['grade'] > 0) {
                $table->where('grade_id', $postData['grade']);
            }

            if (isset($postData['classs']) && $postData['classs'] > 0) {
                $table->where('class_id', $postData['classs']);
            }

            if (isset($postData['username'])) {
                $table->where('name|school|card|mobile', 'like', '%' . $postData['username'] . '%');
            }


            $userlist = $table
                ->limit($page, $limit)
                ->order($order)
                ->select();

            $count = $table->count();
            return $this->tableList(0, '成功', $userlist, $count);
        }

        $calss = db('grade')->where("type", 1)->select();
        $grade = db('grade')->where("type", 2)->select();

        $this->assign("grade", $grade);
        $this->assign("class", $calss); //班级

        return $this->fetch();
    }


    /**
     * Info: 学生添加
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/21 22:39
     * Function:  add
     */
    public function add()
    {
        if ($this->request->post()) {
            $postData = array_remove_empty(input('post.'));
            $bool = db('student')->insert($postData);

            if ($bool) {
                $this->result('', 1, '添加成功');
            } else {
                $this->result('', -1, '添加失败');
            }
        }
        $calss = db('grade')->where("type", 1)->select();
        $grade = db('grade')->where("type", 2)->select();

        $this->assign("grade", $grade);
        $this->assign("calss", $calss); //班级


        return $this->fetch();
    }


    /**
     * Info: 学生修改
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/21 22:39
     * Function:  edit
     */
    public function edit()
    {
        if ($this->request->post()) {
            $postData = array_remove_empty(input('post.'));
            if($postData['id'] > 0){
                $id = $postData['id'];
                $bool = db('student')->where('id',$id)->update($postData);
                if($bool){
                    $this->result('',1,'更新成功');
                }else{
                    $this->result('',-1,'更新失败');
                }

            }else{
                $this->result('',-1,'参数错误');
            }
        }
        $calss = db('grade')->where("type", 1)->select();
        $grade = db('grade')->where("type", 2)->select();

        $this->assign("grade", $grade);
        $this->assign("calss", $calss); //班级

        $id = input("id");
        $data = db('student')->where('id',$id)->find();
        $this->assign($data);

        return $this->fetch();
    }

    /**
     * Info: 学生删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/21 22:40
     * Function:  del
     */
    public function del()
    {
        $postData = input('post.id');
        if ($postData['id'] > 0) {
            db('student')->where(['id' => $postData['id']])->delete();
            $this->result('', 1, '已删除');
        }
        $this->result('', -1, '参数错误');
    }

    public function delAll()
    {
        $data = input();

        foreach ($data as $key => $val) {
            db('student')->where(['id' => $val['id']])->delete();
        }
        $this->result('', 1, '已删除');
    }

    public function import()
    {

    }

    public function export()
    {

    }

    public function setfile()
    {
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下

        $filesize = $file->getInfo();


        //获取系统设置的大小
        $setups = db('System')->where('title', 'setup')->value('json');
        $setup = $setups ? json_decode($setups, 1) : 1;
        if ($setup != 1) {
            $size = $setup['image'] * 1024 * 1024;
            $sizes = $setup['image'];
        } else {
            $size = 1 * 1024 * 1024;
            $sizes = 1;
        }

        if ($filesize['size'] > $size) {
            $this->result('', -1, "不能大于 $sizes M", 'json');
        }

        $postfix = explode('.', $filesize['name']);

        if (!in_array($postfix[1], ['jpg', 'png', 'gif', 'jpeg'])) {
            $this->result('', -1, "请按着要求上传", 'json');
        }

        $info = $file->move('../public/uploads/images/', time() * rand(1000, 9999) + rand(100, 999));

        if ($info) {
            $data['name'] = $filesize['name'];
            $data['src'] = '/uploads/images/' . $info->getSaveName();
            $this->result($data, 0, "上传成功", 'json');
        } else {
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
}