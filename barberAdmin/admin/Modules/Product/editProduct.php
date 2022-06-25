<?php 
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function getProduct($id){
    global $connectDb;
    $table = "product";
    $sql = "SELECT * from $table WHERE maSanPham = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
    return $result[0];
}
if(isset($_GET['maSanPham']) && isset($_GET['action']) && $_GET['action'] == "getProduct"){
    $hd = getProduct(($_GET['maSanPham']));
    echo(json_encode($hd,JSON_UNESCAPED_UNICODE));
}

function updateProduct($idProduct,$price){
    global $connectDb;
    $table = "product";
    $sql = "UPDATE $table SET giaTien ='".$price."' WHERE maSanPham = '".$idProduct."'  ";
    $rs = mysqli_query($connectDb,$sql);
}
if(isset($_POST['maSanPham']) && isset($_POST['giaTien']) && isset($_POST['action']) && $_POST['action'] == "updateProduct"){
    updateProduct($_POST['maSanPham'],$_POST['giaTien']);
}
?>