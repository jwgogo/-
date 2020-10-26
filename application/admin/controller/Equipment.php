<?php
/**
 * User: 伍先生
 * DateTime: 2020/3/18 20:08
 * Class:  Equipment
 * Info: 设备操作
 */

namespace app\admin\controller;
use app\jwcode\controller\AdminBasic;

class Equipment extends  AdminBasic
{

    /**
     * Info: 设备列表
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 20:56
     * Function:  EquipmentList
     */
    public function EquipmentList(){
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

            $table = db('equipment');

            if(isset($postData['mark'])){
                $table->where('mark','like','%'.$postData['mark'].'%');
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
     * Info: 设备添加
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 20:57
     * Function:  add
     */
    public function add(){
        if($this->request->post()){
            $postData = array_remove_empty(input('post.'));

            $rule =   [
                'mark|设备号'  => 'require',
                'device|设备ID'   => 'require',
                'title|设备名称'   => 'require',
                'site|设备位置'   => 'require',
                'signin|机器类型'   => 'require',
                'turnover|进出'   => 'require',
            ];
            $validate = new \think\Validate;
            $validate->rule($rule);

            if (!$validate->check($postData)) {
                $this->result('',-1,$validate->getError());
            }


            $inertData['mark'] = $postData['mark'];
            $inertData['device'] = $postData['device'];
            $inertData['title'] = $postData['title'];
            $inertData['site'] = $postData['site'];
            $inertData['signin'] = $postData['signin'];
            $inertData['turnover'] = $postData['turnover'];


            $inertData['addtime'] = $inertData['uptime'] = date("Y-m-d H:i:s");

            $bool = db('equipment')->insert($inertData);

            if($bool){
                $this->result('',1,'设备添加成功');
            }else{
                $this->result('',-1,'设备添加失败');
            }



        }
        return $this->fetch();
    }


    /**
     * Info: 设备修改
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
                    'mark|设备号'  => 'require',
                    'device|设备ID'   => 'require',
                    'title|设备名称'   => 'require',
                    'site|设备位置'   => 'require',
                    'signin|机器类型'   => 'require',
                    'turnover|进出'   => 'require',
                ];
                $validate = new \think\Validate;
                $validate->rule($rule);

                if (!$validate->check($postData)) {
                    $this->result('',-1,$validate->getError());
                }


                $updata['mark'] = $postData['mark'];
                $updata['device'] = $postData['device'];
                $updata['title'] = $postData['title'];
                $updata['site'] = $postData['site'];
                $updata['signin'] = $postData['signin'];
                $updata['turnover'] = $postData['turnover'];
                $updata['uptime'] = date("Y-m-d H:i:s");

                $bool = db('equipment')->where('id',$postData['id'])->update($updata);
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
            $equipment = db('equipment')->where('id',$id)->find();
            $this->assign($equipment);
            return $this->fetch();
        }
    }


    /**
     * Info: 设备删除
     * Argument :
     * User: 伍先生
     * DateTime: 2020/3/18 21:11
     * Function:  del
     */
    public function del(){
        $postData = input('post.');
        if($postData['id']>0){
            db('equipment')->where(['id'=>$postData['id']])->delete();
            $this->result('',1,'已删除');
        }
        $this->result('',-1,'参数错误');
    }
}