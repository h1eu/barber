<?php
include_once('../../../db/config.php');
require '../../../vendor/autoload.php';
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'dbdantn', 
      'api_key' => '415578573115752', 
      'api_secret' => 'vLhufNYYBmLzcExW2hxQYbGJses'],
    'url' => [
      'secure' => true]]);



$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function addProduct($name, $price, $type, $des, $imgUrl, $idImg)
{
    global $connectDb;
    $table = "product";
    $sql = "INSERT INTO $table (tenSanPham,giaTien,loai,moTa,imgProduct,imgIdProduct) VALUES ('" . $name . "', '" . $price . "', '" . $type . "', '" . $des . "', '" . $imgUrl . "', '".$idImg."')";
    $rs = mysqli_query($connectDb, $sql);
}
$addProduct = "addProduct";
// if (isset($_POST['tenSanPham']) && isset($_POST['giaTien']) && isset($_POST['loai']) && isset($_POST['moTa']) 
//  && isset($_FILES['imgProduct']) && isset($_FILES['imgIdProduct']) && isset($_POST['action']) && $_POST['action'] == $addProduct) {
    if(isset($_POST['action'])){

    $urlImg = "";
    $target_dir    = "upload/";
    $target_file   = $target_dir . basename($_FILES["img"]["name"]);
    $allowUpload   = true;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $maxfilesize   = 8000000;
    $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');

    if (!isset($_FILES["img"])) {
        echo "Dữ liệu không đúng cấu trúc";
        die;
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
             $data = (new UploadApi())->upload($target_file);
             $urlImg = $data['secure_url'];
             $imgId = $data['public_id'];
             var_dump($_POST['moTa']);
             unlink($target_file);
             $add = addProduct($_POST['tenSanPham'],$_POST['giaTien'],$_POST['loai'],$_POST['moTa'],$urlImg,$imgId);
        }  
    }
  
     
}
            
            
   