<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

$table = "barbermeeting";
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
        <td class="text-left"><?php echo $row['tenThoCatToc']; ?></td>
        <td class="text-left"><?php 
            $sqls = "SELECT * from user WHERE maNguoiDung = '".$row['maNguoiDung']."'" ;
            $rss = mysqli_query($connectDb,$sqls);
            $results = mysqli_fetch_all($rss,MYSQLI_ASSOC);
            echo ($results[0]['hoVaTen']); ?></td>
        <td class="text-left"><?php echo $row['ngay']; ?></td>
        <td class="text-left"><?php echo $row['gio']; ?></td>
        <td class="text-left"><?php echo $row['diaChiCuaHang']; ?></td>
        <td class="text-left"><?php 
            if($row['tinhTrangLichHen'] == "true"){
                echo("Được hẹn");
            }
            else if ($row['tinhTrangLichHen'] == "false"){
                echo("Huỷ");
            }
         ?></td>
        <td class="text-center"><button id="button_cancel" class="btn btn-sm btn-danger" value="<?php echo $row['maLichCatToc'];?> "
        <?php
        $check = $row['tinhTrangLichHen'];
        if($check == "false") { ?> disabled <?php } ?>><i class="fas fa-trash"></i> Huỷ</button></td>
    </tr>
<?php
}
?>
