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
function getAllHairdresser()
{
    global $connectDb;
    $table = "hairdresser";
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
                <h2 class="mt-4" id="noti">Thông tin Thợ cắt tóc</h2>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Thông tin Thợ cắt tóc</li>
            </ol>
            <div class="card mb-4" style="width:95%;">
                <div class="card-body">
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                        <div class="dataTable-top">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                Thêm thợ cắt tóc
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thêm Thợ cắt tóc</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="insert_hairdresser" enctype="multipart/form-data">
                                                <label>Tên thợ cắt tóc</label>
                                                <input type="text" id="hairName" class="form-control" placeholder="Nhập Tên thợ cắt tóc">
                                                <label>Tuổi</label>
                                                <input type="number" id="hairAge" class="form-control" placeholder="Nhập tuổi thợ cắt tóc">
                                                <label>Kiểu tóc chính</label>
                                                <input type="text" id="hairListHair" class="form-control" placeholder="Nhập kiểu tóc chính">
                                                <label>Ảnh</label>
                                                <input type="file" id="hairAvt" name="file" class="form-control" placeholder="ảnh">
                                                <label>Cửa hàng hoạt động</label>
                                                <select type="" id="hairStore" class="form-control" placeholder="Cửa hàng hoạt động">
                                                    <option value="">Mời bạn chọn</option>
                                                    <?php
                                                    $query = "SELECT * FROM store";
                                                    $result = mysqli_query($connectDb, $query);
                                                    $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                    foreach ($r as $item) :
                                                    ?>
                                                        <option value="<?php echo ($item['maCuaHang']); ?>"><?php echo ($item['diaChi']); ?></option>
                                                    <?php
                                                    endforeach
                                                    ?>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="button_cancel" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                            <button type="button" id="button_insert" class="btn btn-primary">Thêm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dataTable-container">
                            <table id="datatablesSimple" class="dataTable-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;" class="text-center"><a href="#">STT</a></th>
                                        <th style="width: 15%;" class="text-center"><a href="#">Tên thợ</a></th>
                                        <th style="width: 5%;" class="text-center"><a href="#">Tuổi</a></th>
                                        <th style="width: 15%;" class="text-center"><a href="#">Kiểu tóc chính</a></th>
                                        <th style="width: 20%;" class="text-center"><a href="#">Ảnh</a></th>
                                        <th style="width: 30%;" class="text-center"><a href="#">Cửa hàng hoạt động</a></th>
                                        <th style="width: 5%;" class="text-center"><a href="#">Xoá</a></th>
                                        <th style="width: 5%;" class="text-center"><a href="#">Sửa</a></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyHairdresser">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật địa chỉ cửa hàng cho Thợ cắt tóc</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" id="Update_hairdresser">
                                            <label>Tên thợ cắt tóc</label>
                                            <input type="text" id="updateHairName" class="form-control" placeholder="" readonly>
                                            <label>Tuổi</label>
                                            <input type="number" id="updateHairAge" class="form-control" placeholder="" readonly>
                                            <label>Kiểu tóc chính</label>
                                            <input type="text" id="updateHairListHair" class="form-control" placeholder="" readonly>
                                            <label>Ảnh</label>
                                            <input type="file" id="updateHairAvt" name="file" class="form-control" placeholder="" readonly>
                                            <label>Cửa hàng hoạt động</label>
                                            <select type="" id="updateHairStore" class="form-control" placeholder="">
                                                <option value="">Mời bạn chọn</option>
                                                <?php
                                                $query = "SELECT * FROM store";
                                                $result = mysqli_query($connectDb, $query);
                                                $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                foreach ($r as $item) :
                                                ?>
                                                    <option value="<?php echo ($item['maCuaHang']); ?>"><?php echo ($item['diaChi']); ?></option>
                                                <?php
                                                endforeach
                                                ?>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="button_close" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                        <button type="button" id="button_save" class="btn btn-primary">Lưu</button>
                                    </div>
                                </div>
                            </div>
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
    <script src="<?php echo base_url() ?>/js/scriptHairdresser.js"></script>
    <?php
    include('../../../layout/footer.php');
    ?>