<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

//入口函数
$postJson = file_get_contents('php://input');
$_POST = json_decode($postJson, true);
echo $_POST;
echo '123';