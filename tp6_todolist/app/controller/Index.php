<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
        return 'Hello';
    }

    // public function hello($name = 'ThinkPHP6')
    // {
    //     return 'hello,' . $name;
    // }

    public function doneTask(){
        $id = input('post.id');
        $sql = "update task set Status = '1' and isDelete = '0' where Id = '{$id}'";
        $result = Db::execute($sql);
        if($result > 0){
            return json([
                'code' => 200,
                'msg' => '更新成功',
            ]);
        }
    }

    public function deleteTask($id){
        $sql = "delete from task where id = '{$id}'";
        $result = Db::execute($sql);
        if($result > 0){
            return json([
                'code' => 200,
                'msg' => '删除成功',
            ]);
        }
    }

    public function queryTasks($date){
        $sql = "select * from task where TaskDate between'{$date}' and '${date} 23:59:59.990' and isDelete = '0' order by Status,CreateTime desc";
        $result = Db::query($sql);
        return json([
            'code' => 200,
            'msg' => '查询成功',
            'data' => $result
        ]);
    }

    public function addTask(){
        $taskDate = input('post.taskDate');
        $taskContent = input('post.taskContent');
        $createTime = date('Y-m-d H:i:s', time());
        $updateTime = $createTime;
        $sql = "INSERT INTO task(TaskDate,Task,createTime,updateTime,Status) VALUES('{$taskDate}','{$taskContent}','$createTime','$updateTime','0')";
        // dump($sql);
        // dump($sql);
        $result = Db::execute($sql);
        // dump($result);//空数组
        if($result > 0){
            return json([
                'code' => 200,
                'msg' => '插入成功',
            ]);
        }
    }
}
