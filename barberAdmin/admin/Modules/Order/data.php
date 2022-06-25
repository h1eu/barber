<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}


$table = "bill";
$sql = "SELECT * FROM $table ";
$rs = mysqli_query($connectDb, $sql);
$stt = 0;
foreach (mysqli_fetch_all($rs,MYSQLI_ASSOC) as $row) {
    $stt++;
?>
    <tr>
        <td class="text-center"><?php echo $stt; ?></td>
        <td class="text-left"><?php $sql = 
            "SELECT * FROM user WHERE maNguoiDung = '".$row['maNguoiDung']."'";
            $rs = mysqli_query($connectDb,$sql);
            $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
            echo ($result[0]['hoVaTen']); ?></td>
        <td class="text-left"><?php
            $sql = "SELECT * FROM productinbill WHERE maDonHang = '".$row['maDonHang']."'";
            $rs = mysqli_query($connectDb,$sql);
            $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
            echo ($result[0]['tenSanPham']);
            ?></td>
        
        <td class="text-left"><?php  echo $row['tongTien'] . " vnd" ;    ?></td>
        <td class="text-left"><?php  echo $row['diaChiGiaoHang'] ;    ?></td>
        <td class="text-left"><?php  $check = $row['tinhTrangDonHang'];
        if( $check== "wait"){
            echo ("chờ xác nhận");}  
        else if ($check == "comfirm") {
            echo ("đã xác nhận");}
        else if($check == "destroy"){
                echo ("đã huỷ");
            }
          ?></td>
        <td class="text-left"><?php  echo $row['phuongThucThanhToan'] ;    ?></td>
        <td class="text-left"><?php  echo $row['soDienThoaiNhanHang'] ;    ?></td>
        <td class="text-center"><button id="button_comfirm" class="btn btn-sm btn-success" value="<?php echo $row['maDonHang']; ?>" <?php
        $check = $row['tinhTrangDonHang'];
        if($check == "destroy" || $check == "comfirm") { ?> disabled <?php } ?>><i class="fa-solid fa-check"></i> xác nhận</button></td>
        <td class="text-center"><button class="btn btn-sm btn-danger" id="btndestroy" value="<?php echo $row['maDonHang']; ?>" <?php
        $check = $row['tinhTrangDonHang'];
        if($check == "destroy") { ?> disabled <?php } ?>><i class="fa-solid fa-delete"></i> Huỷ</button></td>
    </tr>
<?php
}
?>
