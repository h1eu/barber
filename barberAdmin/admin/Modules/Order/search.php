<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}
function searchUser($keySearch)
{
    global $connectDb;
    $table = "user";
    $sql = " SELECT * FROM $table WHERE hoVaTen like '" . $keySearch . "%' ";
    $rs = mysqli_query($connectDb, $sql);
    $result = mysqli_fetch_all($rs, MYSQLI_ASSOC);
    return $result;
}

function searchOrder($keySearch){
    $user = searchUser($keySearch);
    $array = array();
    if(sizeof($user) > 0){
        foreach($user as $item){
            global $connectDb;
            $table = "bill";
            $sql = " SELECT * FROM $table WHERE maNguoiDung = '" . $item['maNguoiDung'] . "' ";
            $rs = mysqli_query($connectDb, $sql);
            $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
            array_push($array,$result);
        }
       
    }
    return $array;
}

if (isset($_POST['keySearch']) && isset($_POST['action']) && $_POST['action'] == "searchOrder") {
    $search = searchOrder($_POST['keySearch']);
    
    if (sizeof($search) > 0) {
        $stt = 0;
        $rowS = array_reverse($search[0]);
        foreach ($rowS as $row) {
            $stt++;
?>
            <tr>
        <td class="text-center"><?php echo $row['maDonHang']; ?></td>
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
    }
}

?>