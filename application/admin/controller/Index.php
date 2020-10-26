<?php
/**
 * Created by PhpStorm.
 * User: 伍先生
 * QQ  : 3383600886
 * Date: 2019/8/25
 * Time: 17:52
 * Info: 后台首页
 */

namespace app\admin\controller;

use app\jwcode\controller\AdminBasic;

class Index extends AdminBasic
{
    public function index(){
        //菜单渲染
        //var_dump(session('account')["role"]);die;
        $list = catalogue(session('account')['role']);
        $this->assign('list',$list);
        return  $this->fetch();
    }

    /**
     * Info: 管理员修改
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

                unset($updata['account']);
                $bool = db('admin')->where($where)->update($updata);
                if($bool){
                    $this->result('',1,'更新成功');
                }else{
                    $this->result('',-1,'更新失败');
                }

            }else{
                $this->result('',-1,'参数错误');
            }

        }else{
            $list = db('role')->where('id','<>',1)->select();
            $this->assign('list',$list);
            return $this->fetch();
        }
    }

    public function welcome(){
        return  $this->fetch();
    }
    public function bigdata(){
        return  $this->fetch();
    }
}