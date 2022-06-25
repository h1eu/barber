<?php 
include_once('../../../db/config.php');
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
    return $result[0];
}
if(isset($_GET['maBaiViet']) && isset($_GET['action']) && $_GET['action'] == "getBaiViet"){
    $hd = getPost(($_GET['maBaiViet']));
    echo(json_encode($hd,JSON_UNESCAPED_UNICODE));
}


function updatePost($idPost,$title, $content){
    global $connectDb;
    $table = "post";
    $sql = "UPDATE $table SET tieuDe ='".$title."', noiDung = '".$content."' WHERE maBaiViet = '".$idPost."'  ";
    echo($sql);
    $rs = mysqli_query($connectDb,$sql);
}
if(isset($_POST['maBaiViet']) && isset($_POST['tieuDeNew']) && isset($_POST['noiDungNew']) && isset($_POST['action']) && $_POST['action'] == "updatePost"){
    updatePost($_POST['maBaiViet'],$_POST['tieuDeNew'],$_POST['noiDungNew']);
}
?>