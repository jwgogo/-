<?php
/**
 * Created by PhpStorm.
 * User: 伍先生
 * QQ  : 3383600886
 * Date: 2019/8/29
 * Time: 22:48
 * Info: 说明
 */

namespace app\jwcode\controller;


use think\Controller;
use think\facade\View;
use think\Request;

class AdminBasic extends Controller
{
    protected function initialize()
    {

        if(is_login() == false){
            $this->redirect('/admin/login/index');
        }

        //后台用户信息
        $data = db('admin')->where('id',session('admin'))->find();
        $this->assign('userinfo',$data);

        //系统信息
        $data = db('System')->where('title','website')->value('json');
        $data = json_decode($data,1);
        $this->assign("website",$data);

        //后台权限
        $this->is_role();
    }

    public function tableList($code=200,$msg='成功',$data=null,$count=0){

        if(!is_array($data)){
            $data = json_decode($data);
        }
        $result['code'] = $code;
        $result['msg'] = $msg;
        $result['count'] = $count;
        $result['data'] = $data;
        return $result;
    }

    /**
     * Info: 获取当前访问路由
     * Argument :
     * User: 伍先生
     * Date: 2019/9/8
     * Time: 10:57
     */
    private function getActionUrl()
    {
        $module     = request()->module();
        $controller = request()->controller();
        $controller = strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $controller), "_"));
        $action     = request()->action();
        $url        = '/'.$module.'/'.$controller.'/'.$action;
        //return $url;
        return strtolower($url);
    }

    /**
     * Info: 权限操作
     * Argument :
     * User: 伍先生
     * Date: 2019/9/8
     * Time: 14:55
     */
    public function is_role(){
        $url  = $this->getActionUrl();
        $id = session('account')['role'];
        $authority = db('authority')->where('way',$url)->value('id');
        //没有记录的  谁都可以操作
        if($authority == NUll){
            return true;
        }

        $role = db('role')->where('id',$id)->value('role');

        $arr = explode(",", $role);

        if(in_array($authority,$arr)){
            return true;
        }else{
            $this->error('暂无权限操作');
        }



    }


}