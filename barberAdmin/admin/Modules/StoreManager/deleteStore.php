<?php
    include_once('../../../db/config.php');
    $db = new db();
    try {
        $connectDb = $db->connectDB();
    } catch (PDOException $e) {
        echo "lỗi kết nối: " . $e->getMessage();
    }
    function DeleteAddressStore($idAddress){
        global $connectDb;   
        $table = "store";
        $sql = " DELETE FROM $table WHERE maCuaHang = '".$idAddress."' ";
        $rs = mysqli_query($connectDb,$sql);
    }
   
    if(isset($_POST['maCuaHang']) && isset($_POST['action']) && $_POST['action'] == "deleteStore"){
        $delete = DeleteAddressStore($_POST['maCuaHang']);
    }
   

 

?>
