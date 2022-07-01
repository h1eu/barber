<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

$table = "post";
$sql = "SELECT * FROM $table ";
$rs = mysqli_query($connectDb, $sql);
$stt = 0;
$array = mysqli_fetch_all($rs,MYSQLI_ASSOC);
$rowS = array_reverse($array);
foreach ($rowS  as $row) {
    $stt++;
?>
    <tr>
        <td class="text-center"><?php echo $stt; ?></td>
        <td class="text-left"><?php echo $row['chuyenMuc']; ?></td>
        <td class="text-left"><?php echo $row['tieuDe']; ?></td>
        <td class="text-left"><?php  
           // $texts = explode("</p>", $row['moTa']);
            $texts = $row['noiDung'];
            $text = substr($texts,0,20);
            // foreach($texts as $key =>$text){
            //     if($key > 4){
            //         break;
            //     }
            echo($text."...");
            //};
            ?></td>
        <td class="text-center "><img src="<?php if(isset($row['imgPost'])){
                echo $row['imgPost'];
        } else echo "không chứa ảnh"; ?>" width="100px" height="100px"></img></td>
        <td class="text-center"><button id="button_delete" class="btn btn-sm btn-danger" value="<?php echo $row['maBaiViet']; ?>"><i class="fas fa-trash"></i> Xoá</button></td>
        <td class="text-center"><button class="btn btn-sm btn-primary" id="btnEdit" value="<?php echo $row['maBaiViet']; ?>"><i class="fas fa-edit"></i> Sửa</button></td>
    </tr>
<?php
}
?>
