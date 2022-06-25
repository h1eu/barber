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



require('../../../layout/header.php');
?>
<main>
    <div class="container-fluid px-4">
        <div class="nav-tittle">
            <h2 class="mt-4" id="noti">Quản lý Đơn hàng</h2>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Quản lý Đơn hàng</li>
        </ol>
                    <div class="dataTable-container">
                        <table id="datatablesSimple" class="dataTable-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;" class="text-center"><a href="#">STT</a></th>
                                    <th style="width: 10%;" class="text-center"><a href="#">Tên người mua</a></th>
                                    <th style="width: 10%;" class="text-center"><a href="#">Tên sản phẩm</a></th>
                                    <th style="width: 10%;" class="text-center"><a href="#">Tổng tiền</a></th>
                                    <th style="width: 15%;" class="text-center"><a href="#">Địa chỉ giao hàng</a></th>
                                    <th style="width: 10%;" class="text-center"><a href="#">Tình trạng đơn hàng</a></th>
                                    <th style="width: 10%;" class="text-center"><a href="#">Phương thức thanh toán</a></th>
                                    <th style="width: 10%;" class="text-center"><a href="#">Số điện thoại nhận hàng</a></th>
                                    <th style="width: 5%;" class="text-center"><a href="#">Xác nhận</a></th>
                                    <th style="width: 5%;" class="text-center"><a href="#">Huỷ</a></th>
                                </tr>
                            </thead>
                            <tbody id="bodyOrder">

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
<script src="<?php echo base_url() ?>/js/scriptOrder.js"></script>
<?php
include('../../../layout/footer.php');
?>