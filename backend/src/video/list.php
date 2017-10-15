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
    case 'getMagicVideoList':
        $sql = "SELECT * FROM video";
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
    case 'addMagicVideoInfo':
        $stmt = $conn->prepare("INSERT INTO video (video_name, video_link,video_star, video_type, video_desc) VALUES (?,?,?,?,?)");
        $stmt->bind_param("ssiss", $video_name, $video_link, $video_star, $video_type, $video_desc);
        $video_name = $_POST['data']['name'];
        $video_link = $_POST['data']['link'];
        $video_star = $_POST['data']['star'];
        $video_type = $_POST['data']['type'];
        $video_desc = $_POST['data']['desc'];
        $stmt->execute();
        $stmt->close();
        echo json_encode([]);
        break;
    case 'editMagicVideoInfo':
        $stmt = $conn->prepare("UPDATE video SET video_name = ?, video_link = ?, video_star=?, video_type=?, video_desc=? WHERE video_id = ?");
        $stmt->bind_param("ssissi", $video_name, $video_link, $video_star, $video_type, $video_desc,$video_id);
        $video_id = $_POST['data']['id'];
        $video_name = $_POST['data']['name'];
        $video_link = $_POST['data']['link'];
        $video_star = $_POST['data']['star'];
        $video_type = $_POST['data']['type'];
        $video_desc = $_POST['data']['desc'];
        $stmt->execute();
        $stmt->close();
        echo json_encode([]);
        break;
    case 'deleteMagicVideoInfo':
        $stmt = $conn->prepare("Delete From video WHERE video_id = ?");
        $stmt->bind_param("i", $video_id);
        $video_id = $_POST['data']['id'];
        $stmt->execute();
        $stmt->close();
        echo json_encode([]);
        break;
}

$mysqlController->disconnectMysql($conn);