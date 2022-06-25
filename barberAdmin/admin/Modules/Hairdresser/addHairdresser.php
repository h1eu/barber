<?php
include_once('../../../db/config.php');
require '../../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dbdantn',
        'api_key' => '415578573115752',
        'api_secret' => 'vLhufNYYBmLzcExW2hxQYbGJses'
    ],
    'url' => [
        'secure' => true
    ]
]);



$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function addHairdresser($name, $age, $listHair, $imgUrl, $idStore, $idImg)
{
    global $connectDb;
    $table = "hairdresser";
    $sql = "INSERT INTO $table (tenThoCatToc,tuoi,kieuTocChinh,img,maCuaHang,id_img) VALUES ('" . $name . "', '" . $age . "', '" . $listHair . "', '" . $imgUrl . "', '" . $idStore . "', '" . $idImg . "')";
    $rs = mysqli_query($connectDb, $sql);
}
$addHairdresser = "addHairdresser";
if (isset($_POST['tenThoCatToc']) && isset($_POST['tuoi']) && isset($_POST['kieuTocChinh']) && isset($_POST['maCuaHang']) && isset($_FILES['img'])  && isset($_POST['action']) && $_POST['action'] == $addHairdresser) {
    $urlImg = "";
    $target_dir    = "uploads/";
    $target_file   = $target_dir . basename($_FILES["img"]["name"]);
    $allowUpload   = true;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $maxfilesize   = 8000000;
    $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');

    if (!isset($_FILES["img"])) {
        echo "Dữ liệu không đúng cấu trúc";
        die;
    }

    if ($_FILES["img"]["size"] > $maxfilesize) {
        $e0 =  "Không được upload ảnh lớn hơn 8mb.";
        echo ($e0);
        $allowUpload = false;
    }

    if (!in_array($imageFileType, $allowtypes)) {
        $e1 =  "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
        echo ($e1);
        $allowUpload = false;
    }
    if ($allowUpload) {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            $data = (new UploadApi())->upload($target_file);
            $urlImg = $data['secure_url'];
            $imgId = $data['public_id'];
            echo ($imgId);
            unlink($target_file);
            $add = addHairdresser($_POST['tenThoCatToc'], $_POST['tuoi'], $_POST['kieuTocChinh'], $urlImg, $_POST['maCuaHang'], $imgId);
        }
    }
}
