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

function getHairdresser($id){
    global $connectDb;
    $table = "product";
    $sql = "SELECT * from $table WHERE maSanPham = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
    return $result;
}

function DeleteHairdresser($id)
{
    global $connectDb;
    $table = "product";
    $sql = " DELETE FROM $table WHERE maSanPham = '" . $id . "' ";
    $rs = mysqli_query($connectDb, $sql);
}
if (isset($_POST['maSanPham']) && isset($_POST['action']) && $_POST['action'] == "deleteProduct") {
    $p = getHairdresser($_POST['maSanPham']);
    $public_id = $p[0]['imgIdProduct'];
    $rs = (new UploadApi())->destroy($public_id);
    $delete = DeleteHairdresser($_POST['maSanPham']);
}
