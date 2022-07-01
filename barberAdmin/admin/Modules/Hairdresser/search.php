<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}
function searchStore($keySearch)
{
    global $connectDb;
    $table = "hairdresser";
    $sql = " SELECT * FROM $table WHERE tenThoCatToc like '%" . $keySearch . "%' ";
    $rs = mysqli_query($connectDb, $sql);
    $result = mysqli_fetch_all($rs, MYSQLI_ASSOC);
    return $result;
}

if (isset($_POST['keySearch']) && isset($_POST['action']) && $_POST['action'] == "searchHairdresser") {
    $search = searchStore($_POST['keySearch']);
    if (sizeof($search) > 0) {
        $stt = 0;
        $rowS = array_reverse($search);
        foreach ($rowS as $row) {
            $stt++;
?>
            <tr>
                <td class="text-center"><?php echo $stt; ?></td>
                <td class="text-left"><?php echo $row['tenThoCatToc']; ?></td>
                <td class="text-center"><?php echo $row['tuoi']; ?></td>
                <td class="text-left"><?php echo $row['kieuTocChinh']; ?></td>
                <td class="text-center "><img src="<?php echo $row['img']; ?>" width="100px" height="100px"></img></td>
                <td class="text-left"><?php
                                        $query = "SELECT diaChi FROM store WHERE maCuaHang = '" . $row['maCuaHang'] . "'";
                                        $result = mysqli_query($connectDb, $query);
                                        $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                        echo ($r[0]['diaChi']); ?></td>
                <td class="text-center"><button id="button_delete" class="btn btn-sm btn-danger" value="<?php echo $row['maThoCatToc']; ?>"><i class="fas fa-trash"></i> Xoá</button></td>
                <td class="text-center"><button class="btn btn-sm btn-primary" id="btnEdit" value="<?php echo $row['maThoCatToc']; ?>"><i class="fas fa-edit"></i> Sửa</button></td>
            </tr>
<?php

        }
    }
}

?>