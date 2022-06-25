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
    $table = "hairdresser";
    $sql = "SELECT * from $table WHERE maThoCatToc = '".$id."' ";
    $rs = mysqli_query($connectDb,$sql);
    $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
    return $result;
}

function DeleteHairdresser($id)
{
    global $connectDb;
    $table = "hairdresser";
    $sql = " DELETE FROM $table WHERE maThoCatToc = '" . $id . "' ";
    $rs = mysqli_query($connectDb, $sql);
}
if (isset($_POST['maThoCatToc']) && isset($_POST['action']) && $_POST['action'] == "deleteHairdresser") {
    $hd = getHairdresser($_POST['maThoCatToc']);
    $public_id = $hd[0]['id_img'];
    $rs = (new UploadApi())->destroy($public_id);
    $delete = DeleteHairdresser($_POST['maThoCatToc']);
}
