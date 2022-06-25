<?php
include_once('../../../db/config.php');
session_start();
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}
if (!isset($_SESSION['username'])) {
    header("location: /barberAdmin/login.php");
}
function getAllMeeting()
{
    global $connectDb;
    $table = "barbermeeting";
    $sql = "SELECT * FROM $table";
    $rs = mysqli_query($connectDb, $sql);
    $result = mysqli_fetch_all($rs, MYSQLI_ASSOC);
    return $result;
}

require('../../../layout/header.php');
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="nav-tittle">
                <h2 class="mt-4" id="noti">Thông tin Lịch hẹn cắt tóc</h2>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Thông tin lịch cắt</li>
            </ol>
            <div class="card mb-4" style="width:95%;">
                <div class="card-body">
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                        <div class="dataTable-container">
                            <table id="datatablesSimple" class="dataTable-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;" class="text-center"><a href="#">STT</a></th>
                                        <th style="width: 15%;" class="text-center"><a href="#">Tên thợ cắt tóc</a></th>
                                        <th style="width: 15%;" class="text-center"><a href="#">Tên người dùng</a></th>
                                        <th style="width: 10%;" class="text-center"><a href="#">Ngày</a></th>
                                        <th style="width: 10%;" class="text-center"><a href="#">Giờ</a></th>
                                        <th style="width: 20%;" class="text-center"><a href="#">Cửa hàng hẹn</a></th>
                                        <th style="width: 10%;" class="text-center"><a href="#">Tình trạng</a></th>
                                        <th style="width: 10%;" class="text-center"><a href="#">Huỷ lịch</a></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyMeeting">
                                </tbody>
                            </table>
                        </div>
                        <div class="dataTable-bottom">
                            <nav class="dataTable-pagination">
                                <ul class="dataTable-pagination-list">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- <script>
        CKEDITOR.replace('productDes', {
            filebrowserBrowseUrl: '<?php echo base_url() ?>ckfinder/ckfinder.html',
            filebrowserUploadUrl: '<?php echo base_url() ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        });
    </script> -->
    <script src="<?php echo base_url() ?>js/scriptBarberMeeting.js"></script>
    <?php
    include('../../../layout/footer.php');
    ?>