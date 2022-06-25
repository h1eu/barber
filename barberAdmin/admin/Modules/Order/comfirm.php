<?php 
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function comfirmOrder($id){
    global $connectDb;
    $table = "bill";
    $sql = "UPDATE $table SET tinhTrangDonHang = 'comfirm'  WHERE maDonHang = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    if($rs){
        return true;
    }
    else return false;
}

function comfirmProduct($id){
    global $connectDb;
    $table = "productinbill";
    $sql = "UPDATE $table SET trangThaiDatHang = 'comfirm'  WHERE maDonHang = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    if($rs){
        return true;
    }
    else return false;
}

if(isset($_POST['maDonHang']) && isset($_POST['action']) && $_POST['action'] == "comfirmOrder"){
    $check1 = comfirmOrder(($_POST['maDonHang']));
    $check2 = comfirmProduct(($_POST['maDonHang']));
    if($check1 && $check2){
        echo(json_encode(true,JSON_UNESCAPED_UNICODE));
    }
    else  echo(json_encode(false,JSON_UNESCAPED_UNICODE));
   
}


?>