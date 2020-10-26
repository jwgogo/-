<?php
/**
 * Created by PhpStorm.
 * User: 伍先生
 * QQ  : 3383600886
 * Date: 2019/8/29
 * Time: 23:16
 * Info: 前台管理员操作
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class User extends AdminBasic
{
    /**
     * Info: 会员列表
     * Argument :
     * User: 伍先生
     * Date: 2019/8/29
     * Time: 23:25
     */
    public function userList(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            $where=[];
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['id'=>'desc','addtime'=>'desc'];
            if(input('?field') && input('?order')){
                $order = [$postData['field']=>$postData['order']];
            }
            $userlist = db('user');

            if(input('?username') && !empty($postData['username'])){
                $userlist->where('account|username|email|mobile','like','%'.$postData['username'].'%');
            }

            $userlist = $userlist->where($where)->limit($page,$limit)->order($order)->select();

            $count = db('user')->where($where)->count();
            return $this->tableList(0,'成功',$userlist,$count);
        }


        return $this->fetch();



    }

    /**
     * Info: 会员查看
     * Argument :
     * User: 伍先生
     * Date: 2019/8/29
     * Time: 23:26
     */
    public function detail(){
        if($this->request->post()){
            $id = input('id');
            if($id){
                $data = db('user')
                    ->where(['id'=>$id])
                    ->field('id,username,account,email,mobile,mark,gold,is_del,addtime,lasttime,first_ip,last_ip')
                    ->find();

                $this->result($data,1,'成功');
            }else{
                 $this->result('',-1,'无数据');
            }


        }else{
            return  $this->fetch();
        }


    }

    /**
     * Info: 会员添加
     * Argument :
     * User: 伍先生
     * Date: 2019/8/29
     * Time: 23:26
     */
    public function add(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            $rule =   [
                'account|账号'  => 'require|length:6,16',
                'username|用户名'   => 'require|length:2,10',
                'email'   => 'email',
                'pass' => 'require|length:6,16',
                'repass' => 'require|length:6,16',
            ];
            $validate = new \think\Validate;
            $validate->rule($rule);

            if (!$validate->check($postData)) {
                $this->result('',-1,$validate->getError());
            }

            if(account_heavy($postData['account'])){
                $this->result('',-1,'该账号已存在');
            }

            if($postData['pass'] != $postData['repass']){
                $this->result('',-1,'两次密码不一样');
            }

            $inertData['account'] = $postData['account'];
            $inertData['username'] = $postData['username'];
            $inertData['email'] = $postData['email'];
            $inertData['password'] = set_password($postData['pass']);


            $inertData['addtime'] = $inertData['lasttime'] = time();
            $inertData['first_ip'] = $inertData['last_ip'] = get_client_ip();

            $bool = db('user')->insert($inertData);

            if($bool){
                $this->result('',1,'会员添加成功');
            }else{
                $this->result('',-1,'会员添加失败');
            }



        }


        return $this->fetch();
    }

    /**
     * Info: 会员修改
     * Argument :
     * User: 伍先生
     * Date: 2019/8/29
     * Time: 23:26
     */
    public function edit(){
        if($this->request->post()){
            $postData = input('post.');

            $updata = array_remove_empty($postData);

            if($updata['id'] && $updata['account']){

                if(isset($updata['pass'])){
                    $updata['password'] = set_password($updata['pass']);
                    unset($updata['pass']);
                }

                $where['id'] = $updata['id'];
                $where['account'] = $updata['account'];

                $bool = db('user')->where($where)->update($updata);
                if($bool){
                    $this->result('',1,'更新成功');
                }else{
                    $this->result('',-1,'更新失败');
                }

            }else{
                $this->result('',-1,'参数错误');
            }





        }else{
            return $this->fetch();
        }
    }

    /**
     * Info: 会员删除
     * Argument :
     * User: 伍先生
     * Date: 2019/8/29
     * Time: 23:26
     */
    public function del(){
        $postData = input('post.');
        if(input('?id') && !empty($postData['id'])){
            db('user')->where(['id'=>$postData['id']])->delete();
            db('session')->where('user_id',$postData['id'])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }

    /**
     * Info: 会员状态
     * Argument :
     * User: 伍先生
     * Date: 2019/8/29
     * Time: 23:26
     */
    public function state(){
        $postData = input('post.');

        //var_dump($postData);
        if(input('?id') && !empty($postData['id'])){
            db('user')->where(['id'=>$postData['id']])->update(['is_del'=>$postData['del']]);
            $this->result('',1,'成功');
        }
        $this->result('',-1,'参数错误');
    }
}


