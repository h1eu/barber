<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

$table = "store";
$sql = "SELECT * FROM $table ";
$rs = mysqli_query($connectDb, $sql);
$array = mysqli_fetch_all($rs,MYSQLI_ASSOC);
$stt = 0;
$rowS = array_reverse($array);
foreach ($rowS  as $row) {
    $stt++;
?>
    <tr>
        <td class="text-center"><?php echo $stt; ?></td>
        <td class="text-left"><?php echo $row['diaChi']; ?></td>
        <td class="text-center"><button id="button_delete" class="btn btn-sm btn-danger" value="<?php echo $row['maCuaHang']; ?>"><i class="fas fa-trash"></i> Xoá</button></td>
        <td class="text-center"><button class="btn btn-sm btn-primary" id="btnEdit" value="<?php echo $row['maCuaHang']; ?>"><i class="fas fa-edit"></i> Sửa</button></td>
    </tr>
<?php
}
?>
