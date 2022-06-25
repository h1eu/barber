<?php 
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function destroyOrder($id){
    global $connectDb;
    $table = "bill";
    $sql = "UPDATE $table SET tinhTrangDonHang = 'destroy'  WHERE maDonHang = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    if($rs){
        return true;
    }
    else return false;
}

function destroyProduct($id){
    global $connectDb;
    $table = "productinbill";
    $sql = "UPDATE $table SET trangThaiDatHang = 'destroy'  WHERE maDonHang = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    if($rs){
        return true;
    }
    else return false;
}

if(isset($_POST['maDonHang']) && isset($_POST['action']) && $_POST['action'] == "destroyOrder"){
    $check1 = destroyOrder(($_POST['maDonHang']));
    $check2 = destroyProduct(($_POST['maDonHang']));
    if($check1 && $check2){
        echo(json_encode(true,JSON_UNESCAPED_UNICODE));
    }
    else  echo(json_encode(false,JSON_UNESCAPED_UNICODE));
   
}




?>