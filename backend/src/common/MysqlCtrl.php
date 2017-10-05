<?php

class MysqlCtrl
{
    //连接到数据库
    public function connectMysql()
    {
        $conn = new mysqli("localhost", "root", "19950707", "magic");
        if (mysqli_connect_errno()) {
            exit();
        }
        $conn->query("set names 'utf8'");
        return $conn;
    }

    //关闭数据库连接
    public function disconnectMysql($conn)
    {
        $conn->close();
    }

}