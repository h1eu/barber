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
function getAllStore()
{
    global $connectDb;
    $table = "store";
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
                <h2 class="mt-4" id="noti">Thông tin cửa hàng</h2>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Thông tin cửa hàng</li>
            </ol>
            <div class="card mb-4" style="width:95%;">
                <div class="card-body">
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                        <div class="dataTable-top">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                Thêm cửa hàng
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thêm cửa hàng</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="insert_address_store">
                                                <label>Địa chỉ</label>
                                                <input type="text" id="address_store" class="form-control" placeholder="Nhập địa chỉ">
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
                                        <th style="width: 5%;" class="text-center"><a href="#" >STT</a></th>
                                        <th style="width: 30%;"class="text-center"><a href="#" >Địa chỉ</a></th>
                                        <th style="width: 5%;" class="text-center"><a href="#" >Xoá</a></th>
                                        <th style="width: 5%;" class="text-center"><a href="#" >Sửa thông tin</a></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyStore">
                            
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin cửa hàng</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" id="Update_address_store">
                                            <label>Địa chỉ</label>
                                            <input type="text" id="address_store_old" class="form-control" placeholder="">
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
    <script src="<?php echo base_url() ?>/js/scriptStore.js"></script>
    <?php
    include('../../../layout/footer.php');
    ?>