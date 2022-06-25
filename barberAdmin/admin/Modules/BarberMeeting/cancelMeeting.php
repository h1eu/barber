<?php 
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function cancelMeeting($id){
    global $connectDb;
    $table = "barbermeeting";
    $sql = "UPDATE $table SET tinhTrangLichHen = 'false'  WHERE maLichCatToc = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    if($rs){
        return true;
    }
    else return false;
}
if(isset($_POST['maLichCatToc']) && isset($_POST['action']) && $_POST['action'] == "cancelMeeting"){
    $check = cancelMeeting(($_POST['maLichCatToc']));
    if($check){
        echo(json_encode(true,JSON_UNESCAPED_UNICODE));
    }
    else  echo(json_encode(false,JSON_UNESCAPED_UNICODE));
   
}


?>