<?php
    include_once('../../../db/config.php');
    $db = new db();
    try {
        $connectDb = $db->connectDB();
    } catch (PDOException $e) {
        echo "lỗi kết nối: " . $e->getMessage();
    }
    //them
    $diaChi = $_POST['diaChi'];
    global $connectDb;
    $table = "store";
    $sql = "INSERT INTO $table (diaChi) VALUES ('".$diaChi."')";
    $rs = mysqli_query($connectDb,$sql);
    
?>