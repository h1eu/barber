<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

$table = "product";
$sql = "SELECT * FROM $table ";
$rs = mysqli_query($connectDb, $sql);
$stt = 0;
while ($row = mysqli_fetch_array($rs)) {
    $stt++;
?>
    <tr>
        <td class="text-center"><?php echo $stt; ?></td>
        <td class="text-left"><?php echo $row['tenSanPham']; ?></td>
        <td class="text-left"><?php echo $row['giaTien']; ?></td>
        <td class="text-left"><?php echo $row['loai']; ?></td>
        <td class="text-left"><?php  
           // $texts = explode("</p>", $row['moTa']);
            $texts = $row['moTa'];
            $text = substr($texts,0,20);
            // foreach($texts as $key =>$text){
            //     if($key > 4){
            //         break;
            //     }
            echo($text."...");
            //};
            ?></td>
        <td class="text-center "><img src="<?php echo $row['imgProduct'];?>" width="100px" height="100px"></img></td>
        <td class="text-center"><button id="button_delete" class="btn btn-sm btn-danger" value="<?php echo $row['maSanPham']; ?>"><i class="fas fa-trash"></i> Xoá</button></td>
        <td class="text-center"><button class="btn btn-sm btn-primary" id="btnEdit" value="<?php echo $row['maSanPham']; ?>"><i class="fas fa-edit"></i> Sửa</button></td>
    </tr>
<?php
}
?>
