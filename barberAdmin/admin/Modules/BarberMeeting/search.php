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

function searchMeeting($keySearch){
    $user = searchUser($keySearch);
    
    $array = array();
    if(sizeof($user) > 0){
        foreach($user as $item){
            global $connectDb;
            $table = "barbermeeting";
            $sql = " SELECT * FROM $table WHERE maNguoiDung = '" . $item['maNguoiDung'] . "' ";
            $rs = mysqli_query($connectDb, $sql);
            $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
            array_push($array,$result);
        }
       
    }
    return $array;
}

if (isset($_POST['keySearch']) && isset($_POST['action']) && $_POST['action'] == "searchUser") {
    $search = searchMeeting($_POST['keySearch']);
    
    if (sizeof($search) > 0) {
        $stt = 0;
        $rowS = array_reverse($search[0]);
        foreach ($rowS as $row) {
            $stt++;
?>
            <tr>
                <td class="text-center"><?php echo $stt; ?></td>
                <td class="text-left"><?php echo $row['tenThoCatToc']; ?></td>
                <td class="text-left"><?php
                                        $sqls = "SELECT * from user WHERE maNguoiDung = '" . $row['maNguoiDung'] . "'";
                                        $rss = mysqli_query($connectDb, $sqls);
                                        $results = mysqli_fetch_all($rss, MYSQLI_ASSOC);
                                        echo ($results[0]['hoVaTen']); ?></td>
                <td class="text-left"><?php echo $row['ngay']; ?></td>
                <td class="text-left"><?php echo $row['gio']; ?></td>
                <td class="text-left"><?php echo $row['diaChiCuaHang']; ?></td>
                <td class="text-left"><?php
                                        if ($row['tinhTrangLichHen'] == "true") {
                                            echo ("Được hẹn");
                                        } else if ($row['tinhTrangLichHen'] == "false") {
                                            echo ("Huỷ");
                                        }
                                        ?></td>
                <td class="text-center"><button id="button_cancel" class="btn btn-sm btn-danger" value="<?php echo $row['maLichCatToc']; ?> " <?php
                                                                                                                                                $check = $row['tinhTrangLichHen'];
                                                                                                                                                if ($check == "false") { ?> disabled <?php } ?>><i class="fas fa-trash"></i> Huỷ</button></td>
            </tr>
<?php

        }
    }
}

?>