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
            <h2 class="mt-4" id="noti">Quản lý bài viết</h2>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Quản lý bài viết</li>
        </ol>
        <div class="card mb-4" style="width:95%;">
            <div class="card-body">
                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                    <div class="dataTable-top">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            Thêm bài viết
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document" style="max-width : 850px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thêm Bài viết</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" id="insert_post" enctype="multipart/form-data">
                                            <label>Chuyên mục</label>
                                            <select type="" id="typePost" class="form-control" placeholder="">
                                                <?php
                                                $typePost = array(
                                                    "Giới thiệu",
                                                    "Bảng giá nam",
                                                    "Bảng giá dịch vụ",
                                                    "Bài viết phổ biến",
                                                    "Bạn cần biết",
                                                    "Xu hướng hot nhất",
                                                    "Blog",
                                                    "Tuyển dụng",
                                                    "Cam kết dịch vụ",
                                                    "Về Barber",
                                                    "Điều kiện giao dịch",
                                                    "Chính sách bảo mật thông tin"
                                                );
                                                foreach ($typePost as $item) :
                                                ?>
                                                    <option value="<?php echo ($item); ?>"><?php echo ($item); ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                            </select>
                                            <label>Tiêu đề</label>
                                            <input type="text" id="titlePost" class="form-control" placeholder="Nhập Tiêu đề cho bài viết">
                                            <label>Nội dung</label>
                                            <textarea name="" id="contentPost" cols="30" rows="10" class="form-control" placeholder="Nhập Nội dung cho bài viết"></textarea>
                                            <label>Ảnh</label>
                                            <input type="file" id="imgPost" name="file" class="form-control" placeholder="ảnh">
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
                            <input type="text" class="search form-control" placeholder="Nhập tên bài viết">
                        </div>
                        <h5>Lọc danh sách Bài viết theo loại sản phẩm</h5>
                        <div>
                            <select type="" id="typePostSelected">
                                <option></option>
                                <?php
                                $query = "SELECT DISTINCT chuyenMuc FROM post";
                                $result = mysqli_query($connectDb, $query);
                                $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                foreach ($r as $item) :
                                ?>
                                    <option value="<?php echo ($item['chuyenMuc']); ?>"><?php echo ($item['chuyenMuc']); ?></option>
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
                                    <th style="width: 10%;" class="text-center"><a href="#">Chuyên mục</a></th>
                                    <th style="width: 15%;" class="text-center"><a href="#">Tiêu đề</a></th>
                                    <th style="width: 20%;" class="text-center"><a href="#">Nội dung</a></th>
                                    <th style="width: 20%;" class="text-center"><a href="#">Ảnh</a></th>
                                    <th style="width: 5%;" class="text-center"><a href="#">Xoá</a></th>
                                    <th style="width: 5%;" class="text-center"><a href="#">Sửa</a></th>
                                </tr>
                            </thead>
                            <tbody id="bodyPost">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin Thợ cắt tóc</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="Update_post">
                                        <label>Chuyên mục</label>
                                        <select type="" id="updateTypePostx" class="form-control" placeholder="">
                                            <option id="updateTypePost"><?php echo ($item); ?></option>
                                        </select>
                                        <label>Tiêu đề</label>
                                        <input type="text" id="updateTitlePost" class="form-control" placeholder="Nhập Tiêu đề cho bài viết">
                                        <label>Nội dung</label>
                                        <textarea name="" id="updateContentPost" cols="30" rows="10" class="form-control" placeholder="Nhập Nội dung cho bài viết"></textarea>
                                        <label>Ảnh</label>
                                        <input type="file" id="updateImgPost" name="file" class="form-control" placeholder="ảnh" readonly>
                                        <img id="updatePostImg" src="" width="100px" height="100px"></img>
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
<script src="<?php echo base_url() ?>/js/scriptPost.js"></script>
<?php
include('../../../layout/footer.php');
?>