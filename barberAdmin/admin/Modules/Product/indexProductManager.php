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
function getAllProduct()
{
    global $connectDb;
    $table = "product";
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
                <h2 class="mt-4" id="noti">Thông tin sản phẩm</h2>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Thông tin sản phẩm</li>
            </ol>
            <div class="card mb-4" style="width:95%;">
                <div class="card-body">
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                        <div class="dataTable-top">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                Thêm sản phẩm
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="max-width : 850px;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thêm sản phẩm</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="insert_post" enctype="multipart/form-data">
                                                <label>Tên Sản phẩm</label>
                                                <input type="text" id="productName" class="form-control" placeholder="Nhập Tên Sản phẩm">
                                                <label>Giá tiền</label>
                                                <input type="number" id="productPrice" class="form-control" placeholder="Nhập giá tiền">
                                                <label>Loại</label>
                                                <!-- <input type="text" id="productType" class="form-control" placeholder="Nhập loại sản phẩm"> -->
                                                <select type="" id="productType" class="form-control" placeholder="">
                                                <?php
                                                $typeProduct = array(
                                                    "Máy sấy tóc",
                                                    "Sữa rửa mặt",
                                                    "Chăm sóc tóc",
                                                    "Tạo kiểu tóc",
                                                    "Chăm sóc cơ thể",
                                                    "Chăm sóc da mặt",
                                                    "Sản phẩm khác"
                                                );
                                                foreach ($typeProduct as $item) :
                                                ?>
                                                    <option value="<?php echo ($item); ?>"><?php echo ($item); ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                            </select>
                                                <label>Mô tả</label>
                                                <!-- <div id="desDiv"> -->
                                                <textarea type="text" name="productDes" id="productDes" class="form-control" rows="10" cols="30" placeholder="Nhập mô tả"></textarea>
                                                <!-- </div> -->
                                                <label>Ảnh</label>
                                                <input type="file" id="productImg" name="file" class="form-control" placeholder="ảnh">
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
                            <div class="form-group pull-right">
                                <input type="text" class="search form-control" placeholder="Nhập tên sản phẩm">
                            </div>
                            <h5>Lọc danh sách sản phẩm theo loại sản phẩm</h5>
                            <div>
                                <select type="" id="typeProductSelected" >
                                    <option></option>
                                    <?php
                                    $query = "SELECT DISTINCT loai FROM product";
                                    $result = mysqli_query($connectDb, $query);
                                    $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                    foreach ($r as $item) :
                                    ?>
                                        <option value="<?php echo ($item['loai']); ?>"><?php echo ($item['loai']); ?></option>
                                    <?php
                                    endforeach
                                    ?>
                                </select>
                                <button type="button" id="button_filter" class="btn btn-success">Lọc</button>
                            </div>
                            <table id="datatablesSimple" class="dataTable-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;" class="text-center"><a href="#">STT</a></th>
                                        <th style="width: 15%;" class="text-center"><a href="#">Tên sản phẩm</a></th>
                                        <th style="width: 10%;" class="text-center"><a href="#">Giá tiền</a></th>
                                        <th style="width: 10%;" class="text-center"><a href="#">Loại</a></th>
                                        <th style="width: 25%;" class="text-center"><a href="#">Mô tả</a></th>
                                        <th style="width: 25%;" class="text-center"><a href="#">Ảnh</a></th>
                                        <th style="width: 5%;" class="text-center"><a href="#">Xoá</a></th>
                                        <th style="width: 5%;" class="text-center"><a href="#">Sửa</a></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyProduct">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="max-width : 850px;" role="document">
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật giá tiền cho sản phẩm</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <form method="POST" id="update_post" enctype="multipart/form-data">
                                                <label>Tên Sản phẩm</label>
                                                <input type="text" id="updateProductName" class="form-control" placeholder="">
                                                <label>Giá tiền</label>
                                                <input type="number" id="updateProductPrice" class="form-control" placeholder="">
                                                <label>Loại</label>
                                                <!-- <input type="text" id="productType" class="form-control" placeholder="Nhập loại sản phẩm"> -->
                                                <select type="" id="updateProductType" class="form-control" placeholder="">
                                                <?php
                                                $typeProduct = array(
                                                    "Máy sấy tóc",
                                                    "Sữa rửa mặt",
                                                    "Chăm sóc tóc",
                                                    "Tạo kiểu tóc",
                                                    "Chăm sóc cơ thể",
                                                    "Chăm sóc da mặt",
                                                    "Sản phẩm khác"
                                                );
                                                foreach ($typeProduct as $item) :
                                                ?>
                                                    <option value="<?php echo ($item); ?>"><?php echo ($item); ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                                </select>
                                                <label>Mô tả</label>
                                                <textarea type="text"  id="updateproductDes" class="form-control" rows="10" cols="30" placeholder="" readonly></textarea>
                                                <input type="file" id="updateProductImg" name="file" class="form-control" placeholder="">
                                                <img  id="updateProductImgSrc" src="" width="100px" height="100px"></img>
                                                
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
    <!-- <script>
        CKEDITOR.replace('productDes', {
            filebrowserBrowseUrl: '<?php echo base_url() ?>ckfinder/ckfinder.html',
            filebrowserUploadUrl: '<?php echo base_url() ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        });
    </script> -->
    <script src="<?php echo base_url() ?>js/scriptProduct.js"></script>
    <?php
    include('../../../layout/footer.php');
    ?>