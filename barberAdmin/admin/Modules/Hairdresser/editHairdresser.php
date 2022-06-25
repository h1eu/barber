<?php 
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function getHairdresser($id){
    global $connectDb;
    $table = "hairdresser";
    $sql = "SELECT * from $table WHERE maThoCatToc = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
    return $result;
}
if(isset($_GET['maThoCatToc']) && isset($_GET['action']) && $_GET['action'] == "getHairdresser"){
    $hd = getHairdresser(($_GET['maThoCatToc']));
    echo(json_encode($hd,JSON_UNESCAPED_UNICODE));
}

function updateStoreHairdresser($idHair,$idStore){
    global $connectDb;
    $table = "hairdresser";
    $sql = "UPDATE $table SET maCuaHang ='".$idStore."' WHERE maThoCatToc = '".$idHair."'  ";
    echo($sql);
    $rs = mysqli_query($connectDb,$sql);
}
if(isset($_POST['maThoCatToc']) && isset($_POST['maCuaHangNew']) && isset($_POST['action']) && $_POST['action'] == "updateHairdresser"){
    updateStoreHairdresser($_POST['maThoCatToc'],$_POST['maCuaHangNew']);
}
?>