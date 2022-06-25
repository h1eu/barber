<?php 
    include_once('db/config.php');
    session_start();
    $db = new db();
    try {
        $connectDb = $db->connectDB();
      } catch(PDOException $e) {
        echo "lỗi kết nối: " . $e->getMessage();
      }
      unset($_SESSION['username']);
      header("Location: login.php");
?>