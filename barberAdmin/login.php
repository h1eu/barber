<?php
    include_once('db/config.php');
    session_start();
    $db = new db();
    try {
        $connectDb = $db->connectDB();
      } catch(PDOException $e) {
        echo "lỗi kết nối: " . $e->getMessage();
      }

    function login($username,$password){
        global $connectDb;
        $table = "account";
        $error = "error";
        $sql = "SELECT * FROM $table WHERE tenTaiKhoan = '".$username."' AND matKhau = '".$password."' AND vaiTro = 'admin'";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        if(sizeof($result) > 0){
            return $result;    
        }
        else return $error;
    }

    function getIdAdmin($username,$password){
        global $connectDb;
        $table = "admin";
        $adminAcc = login($username,$password);
        $sql = "SELECT * from $table WHERE maTaiKhoanAdmin = '".$adminAcc[0]['maTaiKhoan']."'" ;
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
   
    if( isset($_POST['submit'])){
        $username = $_POST['tenTaiKhoan'];
        $password = $_POST['matKhau'];

        if(empty($username) || empty($password)){
            echo "<script>alert('Không được để trống')</script>";
        }
        else {
            $check = login($username,$password);
            if($check == "error"){
                echo "<script>alert('Sai tài khoản hoặc mật khẩu')</script>";
            }
            else if(sizeof($check) > 0){
                $idAdm = getIdAdmin($username,$password);
                $_SESSION['idAdmin'] = $idAdm[0]['maAdmin'];
                $_SESSION['username'] = $check[0]['tenTaiKhoan'];
                header("Location: index.php");
            }
        }

        
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Đăng nhập</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method ="POST">
                                            <div class="form-floating mb-3"> 
                                                <input class="form-control" name="tenTaiKhoan" id="inputText" type="text" placeholder="Tên đăng nhập" />
                                                <label for="inputText">Tên đăng nhập</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="matKhau" id="inputPassword" type="password" placeholder="Mật khẩu" />
                                                <label for="inputPassword">Mật khẩu</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0" style="margin-left: 40%;">
                                                <button name = "submit" class="btn btn-primary">Đăng nhập</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>

    </html>