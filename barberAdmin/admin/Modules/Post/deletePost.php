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

function getPost($id){
    global $connectDb;
    $table = "post";
    $sql = "SELECT * from $table WHERE maBaiViet = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
    return $result;
}

function deletePost($id)
{
    global $connectDb;
    $table = "post";
    $sql = " DELETE FROM $table WHERE maBaiViet = '" . $id . "' ";
    $rs = mysqli_query($connectDb, $sql);
}
if (isset($_POST['maBaiViet']) && isset($_POST['action']) && $_POST['action'] == "deletePost") {
    $p = getPost($_POST['maBaiViet']);
    $public_id = $p[0]['idImgPost'];
    if($public_id){
        $rs = (new UploadApi())->destroy($public_id);
        $delete = deletePost($_POST['maBaiViet']);
    }
    else  $delete = deletePost($_POST['maBaiViet']);
    
}
