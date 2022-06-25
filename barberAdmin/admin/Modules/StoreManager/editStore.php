<?php
    include_once('../../../db/config.php');
    $db = new db();
    try {
        $connectDb = $db->connectDB();
    } catch (PDOException $e) {
        echo "lỗi kết nối: " . $e->getMessage();
    }
    
    function getAddStore($id){
        global $connectDb;
        $table = "store";
        $sql = "SELECT diaChi FROM $table WHERE maCuaHang = '".$id."'";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    function updateAddress($id,$diaChiMoi){
        global $connectDb;
        $table = "store";
        $sql = "UPDATE $table SET diaChi ='".$diaChiMoi."' WHERE maCuaHang = '".$id."'";
        $rs = mysqli_query($connectDb,$sql);
    }



    $action= $_POST['action'];
    $actionGetAddress = "getAddress";
    $actionUpdateAddress = "updateAddress";

    if(isset($_POST['maCuaHang']) && isset($action) && $action == $actionGetAddress){
        $diaChiCu = getAddStore($_POST['maCuaHang']);
        echo($diaChiCu[0]['diaChi']);
       
    }

    if(isset($_POST['maCuaHang']) && isset($_POST['diaChiMoi']) && isset($action) && $action == $actionUpdateAddress){
        updateAddress($_POST['maCuaHang'],$_POST['diaChiMoi']);
    }
   
   
?>