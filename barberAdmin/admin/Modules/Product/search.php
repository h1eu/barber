<?php
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}
function searchProduct($keySearch)
{
    global $connectDb;
    $table = "product";
    $sql = " SELECT * FROM $table WHERE tenSanPham like '%" . $keySearch . "%' ";
    $rs = mysqli_query($connectDb, $sql);
    $result = mysqli_fetch_all($rs, MYSQLI_ASSOC);
    return $result;
}

if (isset($_POST['keySearch']) && isset($_POST['action']) && $_POST['action'] == "searchProduct") {
    $search = searchProduct($_POST['keySearch']);
    if (sizeof($search) > 0) {
        $stt = 0;
        $rowS = array_reverse($search);
        foreach ($rowS as $row)  {
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
                                        $text = substr($texts, 0, 20);
                                        // foreach($texts as $key =>$text){
                                        //     if($key > 4){
                                        //         break;
                                        //     }
                                        echo ($text . "...");
                                        //};
                                        ?></td>
                <td class="text-center "><img src="<?php echo $row['imgProduct']; ?>" width="100px" height="100px"></img></td>
                <td class="text-center"><button id="button_delete" class="btn btn-sm btn-danger" value="<?php echo $row['maSanPham']; ?>"><i class="fas fa-trash"></i> Xoá</button></td>
                <td class="text-center"><button class="btn btn-sm btn-primary" id="btnEdit" value="<?php echo $row['maSanPham']; ?>"><i class="fas fa-edit"></i> Sửa</button></td>
            </tr>
<?php

        }
    }
}

?>