<?php
/**
 * Created by PhpStorm.
 * User: 伍先生
 * QQ  : 3383600886
 * Date: 2019/9/8
 * Time: 23:45
 * Info: 说明
 */

namespace app\admin\controller;


use app\jwcode\controller\AdminBasic;

class Log extends AdminBasic
{
    public function log(){
        if($this->request->post()){
            $postData = input('post.');

            $page = 0;
            $limit = 10;
            $where = [];
            $table = db('log');
            if(input('?page') && input('?limit')){
                $page = ($postData['page']-1)*10;
                $limit = $postData['limit'];
            }

            $order = ['time'=>'desc','id'=>'desc'];
            if(input('?field') && input('?order')){
                $order = [$postData['field']=>$postData['order']];
            }

            //var_dump($postData);die;

            if(isset($postData['start'])){
                if($postData['start'] != '' && $postData['end'] != ''){
                    $start = $postData['start'];
                    $end = strtotime($postData['end'])+86399;
                    $table->whereTime('time', 'between', [$start, $end]);
                }

                if($postData['start'] != '' && $postData['end'] == ''){
                    $start = $postData['start'];
                    $end = time()+86399;
                    $table->whereTime('time', 'between', [$start, $end]);
                }

                if($postData['start'] == '' && $postData['end'] != ''){
                    $start = 0;
                    $end = $postData['end'];
                    $table->whereTime('time', 'between', [$start, $end]);
                }

                if($postData['username'] != ''){
                    $table->where('account|ip|param','like','%'.$postData['username'].'%');
                }
            }






            $list = $table
                //->fetchSql(true)
                ->limit($page,$limit)
                ->order($order)
                ->select();

            //echo $list;die;

            $count = $table->where($where)->count();
            return $this->tableList(0,'成功',$list,$count);
        }


        return $this->fetch();
    }

    public function look(){
        $where['id'] = input('id');
        $data = db('log')->where($where)->find();
        $this->assign($data);
        return $this->fetch();

    }

    /**
     * Info: 一周的访问数据
     * User: 伍先生
     * Date: 2019/7/28
     * Time: 11:25
     */
    public function week(){
        $time = [
            date("Y-m-d",strtotime('-6 day')),
            date("Y-m-d",strtotime('-5 day')),
            date("Y-m-d",strtotime('-4 day')),
            date("Y-m-d",strtotime('-3 day')),
            date("Y-m-d",strtotime('-2 day')),
            date("Y-m-d",strtotime('-1 day')),
            date("Y-m-d"),
        ];
        //var_dump($time);die;

        $data['time'] = $time;
        for ($i=0;$i<4;$i++) {
            foreach ($time as $key => $val) {
                //访问总数
                $ipcount = db('log')->whereBetweenTime('time', $val)->count();
                //多少个IP 去重的
                $ipsum = db('log')->whereBetweenTime('time', $val)->group('ip')->count();
                //内部访问
                $nei = db('log')->whereBetweenTime('time', $val)->where('uid', '<>',0)->group('uid')->count();
                //外部 2
                $wai = db('log')->whereBetweenTime('time', $val)->where('uid', 0)->count();

                switch ($i){
                    case 0:
                        $data['msg'][$i][]=$ipcount;
                        break;
                    case 1:
                        $data['msg'][$i][]=$ipsum;
                        break;
                    case 2:
                        $data['msg'][$i][]=$nei;
                        break;
                    case 3:
                        $data['msg'][$i][]=$wai;
                        break;
                }
            }

        }
        return json_encode($data);

    }
}