<?php
include_once('../../../db/config.php');
require '../../../vendor/autoload.php';
session_start();
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'dbdantn', 
      'api_key' => '415578573115752', 
      'api_secret' => 'vLhufNYYBmLzcExW2hxQYbGJses'],
    'url' => [
      'secure' => true]]);

$idAdmin = $_SESSION['idAdmin'];

$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function addPost($chuyenMuc, $tieuDe, $noiDung, $imgPost, $imgIdPost)
{
    global $connectDb;
    global $idAdmin;
    $table = "post";
    $sql = "INSERT INTO $table (chuyenMuc,tieuDe,noiDung,imgPost,idImgPost,maAdmin) VALUES ('" . $chuyenMuc . "', '" . $tieuDe . "', '" . $noiDung . "', '" . $imgPost . "', '" . $imgIdPost . "', '".$idAdmin."')";
    $rs = mysqli_query($connectDb, $sql);
}
$addPost = "addPost";

    if(isset($_POST['action'])){

    $urlImg = "";
    $target_dir    = "upload/";
    $target_file   = $target_dir . basename($_FILES["img"]["name"]);
    $allowUpload   = true;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $maxfilesize   = 8000000;
    $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');

    if (!isset($_FILES["img"])) {
        $allowUpload = false;
    }

    if ($_FILES["img"]["size"] > $maxfilesize)
    {
        echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
        $allowUpload = false;
    }
  
    if (!in_array($imageFileType,$allowtypes ))
    {
       echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
        $allowUpload = false;
    }
    if ($allowUpload)
    {
        
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file))
        {
            global $idAdmin;
             $data = (new UploadApi())->upload($target_file);
             $urlImg = $data['secure_url'];
             $imgId = $data['public_id'];
             unlink($target_file);
             $add = addPost($_POST['chuyenMuc'],$_POST['tieuDe'],$_POST['noiDung'],$urlImg,$imgId,$idAdmin);
        }  
    }
    else{
        global $idAdmin;
        $imgId ="";
        $add = addPost($_POST['chuyenMuc'],$_POST['tieuDe'],$_POST['noiDung'],$urlImg,$imgId,$idAdmin);
    }
  
     
}
            
            
   