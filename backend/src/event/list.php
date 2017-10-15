<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include_once('../common/MysqlCtrl.php');

//入口函数
$postJson = file_get_contents('php://input');
$_POST = json_decode($postJson, true);

$mysqlController = new MysqlCtrl;
$conn = $mysqlController->connectMysql();

switch ($_POST['name']) {
    case 'getMagicEventList':
        $sql = "SELECT * FROM event";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $dataRow = [];
            while ($dbrow = $result->fetch_assoc()) {
                $dataRow[] = $dbrow;
            }
            echo json_encode($dataRow);
        } else {
            echo json_encode([]);
        }
        break;
    case 'addMagicEventInfo':
        $stmt = $conn->prepare("INSERT INTO event ( event_date, event_type,event_desc, event_remark) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $event_date, $event_type, $event_desc, $event_remark);
        $event_date = $_POST['data']['date'];
        $event_type = $_POST['data']['type'];
        $event_desc = $_POST['data']['desc'];
        $event_remark = $_POST['data']['remark'];
        $stmt->execute();
        $stmt->close();
        echo json_encode([]);
        break;
    case 'editMagicEventInfo':
        $stmt = $conn->prepare("UPDATE event SET event_date = ?, event_type = ?, event_desc=?, event_remark=? WHERE event_id = ?");
        $stmt->bind_param("ssssi", $event_date, $event_type, $event_desc, $event_remark, $event_id);
        $event_date = $_POST['data']['date'];
        $event_type = $_POST['data']['type'];
        $event_desc = $_POST['data']['desc'];
        $event_remark = $_POST['data']['remark'];
        $event_id = $_POST['data']['id'];
        $stmt->execute();
        $stmt->close();
        echo json_encode([]);
        break;
    case 'deleteMagicEventInfo':
        $stmt = $conn->prepare("Delete From event WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $event_id = $_POST['data']['id'];
        $stmt->execute();
        $stmt->close();
        echo json_encode([]);
        break;
}

$mysqlController->disconnectMysql($conn);