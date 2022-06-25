<?php
    include_once('config/db.php');
    include_once('model/account.php');
    include_once('model/admin.php');
    include_once('model/barbermeeting.php');
    include_once('model/bill.php');
    include_once('model/cart.php');
    include_once('model/hairdresser.php');
    include_once('model/post.php');
    include_once('model/product.php');
    include_once('model/productincart.php');
    include_once('model/user.php');
    include_once('model/store.php');

    $db = new db();
    try {
        $connectDb = $db->connectDB();
      } catch(PDOException $e) {
        echo "lỗi kết nối: " . $e->getMessage();
      }

      

    //login
    function login($username,$password){
        global $connectDb;
        $table = "account";
        $error = "error";
        $sql = "SELECT * FROM $table WHERE tenTaiKhoan = '".$username."' AND matKhau = '".$password."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        if(sizeof($result) > 0){
            return $result;    
        }
        else return $error;
           
    }
   
    if( isset($_POST['tenTaiKhoan']) && isset($_POST['matKhau']) && isset($_POST['action'] )&& $_POST['action']=="login"){
        $account = login($_POST['tenTaiKhoan'],$_POST['matKhau']);
        if($account == "error"){
            echo ("false");
        }
        else echo ("true");
        
    }

    // register
    // check username
    function checkUsername($username){
        global $connectDb;
        $table = "account";
        $sql = " SELECT * FROM $table WHERE tenTaiKhoan = '".$username."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    if( isset($_POST['tenTaiKhoan']) && isset($_POST['action']) && $_POST['action'] == "checkUsername"){
        $acc = checkUsername($_POST['tenTaiKhoan']);
        echo (json_encode($acc[0],JSON_UNESCAPED_UNICODE)); 
    }


    function getIdAccount($username){
        global $connectDb;
        $table = "account";
        $sql = "SELECT maTaiKhoan FROM $table WHERE tenTaiKhoan = '".$username."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    function registerAccount($username,$password)
    {
        global $connectDb;
        $table1 = "account";
        $sql = "INSERT INTO $table1 (tenTaiKhoan , matKhau) VALUES ('".$username."','".$password."')";
        $rs = mysqli_query($connectDb,$sql);
    }


    function createUser($idAccount){
        global $connectDb;
        $table = "user";
        $sql = "INSERT INTO $table (maTaiKhoanUser) VALUES ('".$idAccount."')";
        $rs = mysqli_query($connectDb,$sql);
    }

    function updateUser($idAccount,$name,$phone,$questionAcc){
        global $connectDb;
        $table = "user";
        $sql = " UPDATE $table SET hoVaTen='".$name."',soDienThoai='".$phone."',cauHoiMatKhau='".$questionAcc."' WHERE maTaiKhoanUser= '".$idAccount."'";
        $rs = mysqli_query($connectDb,$sql);
    }

   

    if( isset($_POST['tenTaiKhoan']) && isset($_POST['matKhau']) && isset($_POST['hoVaTen']) && isset($_POST['soDienThoai']) && isset($_POST['cauHoiMatKhau'])
     && isset($_POST['action']) && $_POST['action'] == "register"){
        $checkUsername = checkUsername($_POST['tenTaiKhoan']);
        if(sizeof($checkUsername) == 0){
            registerAccount($_POST['tenTaiKhoan'],$_POST['matKhau']);
            $idAccount = getIdAccount($_POST['tenTaiKhoan']);
            createUser($idAccount[0]['maTaiKhoan']);
            updateUser($idAccount[0]['maTaiKhoan'],$_POST['hoVaTen'],$_POST['soDienThoai'],$_POST['cauHoiMatKhau']);
            
        }
    }

    // quen mat khau
    function getQuestionForgotPass($idAccUser){
        global $connectDb;
        $table = "user";
        $sql = " SELECT cauHoiMatKhau FROM $table WHERE maTaiKhoanUser = '".$idAccUser."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    function setNewPassword($username,$password){
        global $connectDb;
        $table = "account";
        $sql = "UPDATE $table SET matKhau='".$password."' WHERE tenTaiKhoan = '".$username."'";
        $rs = mysqli_query($connectDb,$sql);
    }

    if(isset($_POST['tenTaiKhoan']) && isset($_POST['cauHoiMatKhau']) && isset($_POST['action']) && $_POST['action']  == "checkUserForgotPass"){
        $idAccUser = getIdAccount($_POST['tenTaiKhoan']);
        $questionPass = getQuestionForgotPass($idAccUser[0]['maTaiKhoan']);  
        $check = strcmp($questionPass[0]['cauHoiMatKhau'],$_POST['cauHoiMatKhau']); 
        if($check == 0){
            echo ("true");
        }
        else echo ("false");
    }

    if(isset($_POST['tenTaiKhoan']) && isset($_POST['matKhau']) && isset($_POST['action']) && $_POST['action']  == "resetPassword"){
        setNewPassword($_POST['tenTaiKhoan'],$_POST['matKhau']);
    }

    function getAllStore(){
        global $connectDb;
        $table = "store";
        $sql = "SELECT * FROM $table ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
    if(isset($_POST['action']) && $_POST['action'] == "getAllStore"){
        $store = getAllStore();
        echo (json_encode($store,JSON_UNESCAPED_UNICODE)); 
    }
    // lay danh sach tho cat toc theo cua hang
    function getHairdresser($idStore){
        global $connectDb;
        $table = "hairdresser";
        $sql = "SELECT * FROM $table WHERE maCuaHang = '".$idStore."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
    if(isset($_POST['maCuaHang']) && isset($_POST['action']) && $_POST['action'] == "getHairdresser"){
        $hairdresser = getHairdresser($_POST['maCuaHang']);
        echo (json_encode($hairdresser,JSON_UNESCAPED_UNICODE)); 
    }

    // lay ten tai khoan
    function getUser($idAccount){
        global $connectDb;
        $table = "user";
        $sql = "SELECT * FROM $table WHERE maTaiKhoanUser = '".$idAccount."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    if(isset($_POST['tenTaiKhoan']) && isset($_POST['action']) && $_POST['action'] == "getUser"){
        $idAccUser = getIdAccount($_POST['tenTaiKhoan']);
        $user = getUser($idAccUser[0]['maTaiKhoan']);
        echo (json_encode($user[0],JSON_UNESCAPED_UNICODE)); 

    }

    // dat lich hen cat toc

    function createBarberMeeting($idUser,$idHairdresser,$nameHairdresser,$day,$hour,$addressStore){
        global $connectDb;
        $table = "barbermeeting";
        $sql = "INSERT INTO $table (maThoCatToc,maNguoiDung,tenThoCatToc,ngay,gio,diaChiCuaHang) VALUES ('".$idHairdresser."','".$idUser."','".$nameHairdresser."','".$day."','".$hour."','".$addressStore."')";
        $rs = mysqli_query($connectDb,$sql);
        var_dump($sql);
    }

    if(isset($_POST['maNguoiDung']) && isset($_POST['maThoCatToc']) && isset($_POST['tenThoCatToc']) && isset($_POST['ngay']) && isset($_POST['gio']) && isset($_POST['diaChiCuaHang']) 
        && isset($_POST['action']) && $_POST['action'] == "createBarberMeeting"){
        createBarberMeeting($_POST['maNguoiDung'],$_POST['maThoCatToc'],$_POST['tenThoCatToc'],$_POST['ngay'], $_POST['gio'], $_POST['diaChiCuaHang']);
    }

    //lay danh sach dat lich
    function getHistoryMeeting($idUser){
        global $connectDb;
        $table = "barbermeeting";
        $sql = "SELECT * FROM $table WHERE maNguoiDung = '".$idUser."'" ;
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    if(isset($_POST['maNguoiDung']) && isset($_POST['action']) && $_POST['action'] == "getHistoryMeeting"){
        $historyMeeting = getHistoryMeeting($_POST['maNguoiDung']);
        echo (json_encode($historyMeeting,JSON_UNESCAPED_UNICODE)); 

    }

    // lay danh sach toan bo tho cat toc

    function getAllHairdresser(){
        global $connectDb;
        $table = "hairdresser";
        $sql = "SELECT * FROM $table";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
    if( isset($_POST['action']) && $_POST['action'] == "getAllHairdresser" ){
        $listHairdresser = getAllHairdresser();
        echo(json_encode($listHairdresser,JSON_UNESCAPED_UNICODE));
    }
   

    // thay doi thong tin tai khoan

    function changeInfoUser($idUser,$name,$phone,$address){
        global $connectDb;
        $table = "user";
        $sql = "UPDATE $table SET hoVaTen='".$name."',soDienThoai='".$phone."', diaChi='".$address."' WHERE maNguoiDung = '".$idUser."' ";
        $rs = mysqli_query($connectDb,$sql);
    }

    if(isset($_POST['maNguoiDung']) && isset($_POST['hoVaTen']) && isset($_POST['soDienThoai']) && isset($_POST['diaChi']) 
        && isset($_POST['action']) && $_POST['action'] == "changeInfoUser"  ){
            changeInfoUser($_POST['maNguoiDung'], $_POST['hoVaTen'], $_POST['soDienThoai'], $_POST['diaChi']);
        }

    // doi mat khau
    function checkOldPassword($idAcc,$password){
        global $connectDb;
        $table = "account";
        $sql = " SELECT * FROM $table WHERE maTaiKhoan = '".$idAcc."' AND matKhau = '".$password."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
    function changePassword($idAcc,$password){
        global $connectDb;
        $table = "account";
        $sql = "UPDATE $table SET matKhau='".$password."' WHERE maTaiKhoan = '".$idAcc."'";
        $rs = mysqli_query($connectDb,$sql);
    }
    if(isset($_POST['maTaiKhoan'])  && isset($_POST['matKhauOld']) && isset($_POST['matKhauNew'])  && isset($_POST['action']) && $_POST['action'] == "changePassword"  ){
            $checkPw = checkOldPassword($_POST['maTaiKhoan'],$_POST['matKhauOld']);
            if(sizeof($checkPw) > 0){
                changePassword($_POST['maTaiKhoan'],$_POST['matKhauNew']);
                echo("true") ;
            }
            else  echo("false") ;
        }

        
    // xu li lich de khong click duoc gio

    function checkHour($addressStore, $idHairdresser ,$day,$status){
        global $connectDb;
        $table = "barbermeeting";
        $sql = "SELECT gio FROM $table WHERE maThoCatToc = '".$idHairdresser."' AND diaChiCuaHang = '".$addressStore."' 
            AND ngay = '".$day."' AND tinhTrangLichHen = '".$status."'" ;
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    if(isset($_POST['maThoCatToc']) && isset($_POST['diaChiCuaHang']) && isset($_POST['ngay']) && isset($_POST['tinhTrangLichHen'])
     && isset($_POST['action']) && $_POST['action'] == "checkHour"){
        $hourUsed = checkHour($_POST['diaChiCuaHang'],$_POST['maThoCatToc'],$_POST['ngay'],$_POST['tinhTrangLichHen']);
        echo (json_encode($hourUsed,JSON_UNESCAPED_UNICODE)); 
    }
  
    // list san pham
    function getAllTypeProduct(){
        global $connectDb;
        $table = "product";
        $sql = "SELECT DISTINCT  loai FROM $table " ;
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    if(isset($_POST['action']) && $_POST['action'] == "getAllTypeProduct"){
        $typeProduct = getAllTypeProduct();
        $type = array();
        foreach($typeProduct as $item){
            array_push($type,$item['loai']);
        }
        echo (json_encode($type,JSON_UNESCAPED_UNICODE)); 
    }

    
    // list full san pham
    function getAllProduct(){
        global $connectDb;
        $table = "product";
        $sql = "SELECT * FROM $table" ;
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    if(isset($_POST['action']) && $_POST['action'] == "getAllProduct"){
        $product = getAllProduct();
        echo (json_encode($product,JSON_UNESCAPED_UNICODE)); 
    }

    // lay san pham theo loai

    function getProductByType($type){
        global $connectDb;
        $table = "product";
        $sql = "SELECT * FROM $table WHERE loai = '".$type."'" ;
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    if(isset($_POST['loai']) && isset($_POST['action']) && $_POST['action'] == "getProductByType"){
        $product = getProductByType($_POST['loai']);
        echo (json_encode($product,JSON_UNESCAPED_UNICODE)); 
    }

    //them san pham vao gio hang

    function getIdCart($idUser){
        global $connectDb;
        $table = "cart";
        $sql = "SELECT maGioHang FROM $table WHERE maNguoiDung = '".$idUser."'" ;
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }

    function addProductToCart($idUser,$idProduct,$nameProduct,$soLuong,$price,$imgProduct){
        global $connectDb;
        $table = "productincart";
        $check = getIdCart($idUser);
        if(sizeof($check) == 0){
            $sql = "INSERT INTO cart (maNguoiDung) VALUES ('".$idUser."')" ;
            $rs = mysqli_query($connectDb,$sql);
            if($rs){
                $idCart = getIdCart($idUser);
                $sqls =  "INSERT INTO $table (maGioHang, maSanPham, tenSanPham , soLuong, giaTien, imgProduct) VALUES ('".$idCart[0]['maGioHang']."', '".$idProduct."', '".$nameProduct."', '".$soLuong."', '".$price."', '".$imgProduct."' )";
                $rss = mysqli_query($connectDb,$sqls); 
                return true;
            }
        }
        else{
            $sqlx = "SELECT * FROM $table WHERE maGioHang = '".$check[0]['maGioHang']."' AND maSanPham = '".$idProduct."'  " ;
            $rsx = mysqli_query($connectDb,$sqlx);
            $checkRsx = mysqli_fetch_all($rsx,MYSQLI_ASSOC);
            if(sizeof($checkRsx) > 0){
                    $s = "UPDATE $table SET soLuong = soLuong + 1 WHERE maGioHang = '".$check[0]['maGioHang']."' AND maSanPham = '".$idProduct."' ";
                    $resusltS = mysqli_query($connectDb,$s);
                    return true;     
            }
            else{
                $sqls = "INSERT INTO $table (maGioHang, maSanPham, tenSanPham ,soLuong, giaTien, imgProduct) VALUES ('".$check[0]['maGioHang']."', '".$idProduct."',  '".$nameProduct."', '".$soLuong."', '".$price."', '".$imgProduct."')";
                $rss = mysqli_query($connectDb,$sqls); 
                return true;
            }
        }
        return false;
    }
    
    function updateCart($idUser,$idProduct,$soLuong){
        global $connectDb;
        $table = "productincart";
        $idCart = getIdCart($idUser);
        if(sizeof($idCart) > 0){
            $sql = "UPDATE $table SET soLuong = '".$soLuong."' WHERE maGioHang = '".$idCart[0]['maGioHang']."' AND maSanPham = '".$idProduct."' " ;
            $rs = mysqli_query($connectDb,$sql);
            return true;
        }
        else return false;
    }

    if(isset($_POST['maNguoiDung']) && isset($_POST['maSanPham']) && isset($_POST['soLuong'])  && isset($_POST['action']) && $_POST['action'] == "updateCart"){
        $check = updateCart($_POST['maNguoiDung'],$_POST['maSanPham'],$_POST['soLuong']);
        if($check){
            echo (json_encode(true,JSON_UNESCAPED_UNICODE));
        }
        else  echo (json_encode(false,JSON_UNESCAPED_UNICODE));
    }

    


    if(isset($_POST['maNguoiDung']) && isset($_POST['maSanPham']) && isset($_POST['tenSanPham']) && isset($_POST['soLuong']) && isset($_POST['giaTien']) && isset($_POST['imgProduct'])
    && isset($_POST['action']) && $_POST['action'] == "addProductToCart" ){
        $rs = addProductToCart($_POST['maNguoiDung'],$_POST['maSanPham'], $_POST['tenSanPham'],$_POST['soLuong'],$_POST['giaTien'],$_POST['imgProduct']);
        if($rs)
        {
            echo (json_encode(true,JSON_UNESCAPED_UNICODE));
        }
        else  echo (json_encode(false,JSON_UNESCAPED_UNICODE));
    }

    // lay thong tin gio hang

    function getInfoCart($idUser){
        global $connectDb;
        $table = "productincart";
        $idCart = getIdCart($idUser);
        if(sizeof($idCart) > 0){
            $sql = "SELECT * FROM $table WHERE maGioHang = '".$idCart[0]['maGioHang']."' AND trangThaiMua = 'false' " ;
            $rs = mysqli_query($connectDb,$sql);
            $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
            return $result;
        }
        else return false;
        
    }

    if(isset($_POST['maNguoiDung']) && isset($_POST['action']) && $_POST['action'] == "getInfoCart"){
        $infoCart = getInfoCart(($_POST['maNguoiDung']));
        if(!$infoCart){
            return null;
        }
        else{
            echo (json_encode($infoCart,JSON_UNESCAPED_UNICODE)); 
        }
    }

    
    function deleteProductInCart($idUser,$idProduct){
        global $connectDb;
        $check = getIdCart($idUser);
        if(sizeof($check) > 0){
            $sqls = "DELETE From productincart WHERE maGioHang = '".$check[0]['maGioHang']."' AND maSanPham = '".$idProduct."'  ";
            $rss = mysqli_query($connectDb,$sqls);
            if($rss){
                return true;
            }
            return false;
        }
        else return false;
    }

    if(isset($_POST['maNguoiDung']) && isset($_POST['maSanPham'])  && isset($_POST['action']) && $_POST['action'] == "deleteProductInCart"){
        $check = deleteProductInCart($_POST['maNguoiDung'],$_POST['maSanPham']);
        if($check){
            echo (json_encode(true,JSON_UNESCAPED_UNICODE)); 
        }
        else echo (json_encode(false,JSON_UNESCAPED_UNICODE)); 
    }
    // xu ly dat hang
   function order($totalPrice, $add, $pttt, $phone,$idUser,$idProduct){
    global $connectDb;
    $table = "bill";
    $sql = "INSERT INTO $table (tongTien, diaChiGiaoHang, phuongThucThanhToan, soDienThoaiNhanHang, maSanPham,maNguoiDung) 
    VALUES ('".$totalPrice."','".$add."', '".$pttt."', '".$phone."' , '".$idUser."', '".$idProduct."' )" ;
    $rs = mysqli_query($connectDb,$sql);   
    if($rs){
        return true;
    }
    else return false;
   }

   if(isset($_POST['tongTien']) && isset($_POST['diaChiGiaoHang']) && isset($_POST['phuongThucThanhToan']) && isset($_POST['soDienThoaiNhanHang']) && isset($_POST['maNguoiDung']) && isset($_POST['maSanPham'])
         && isset($_POST['action']) && $_POST['action'] == "order"){
        $order = order($_POST['tongTien'],$_POST['diaChiGiaoHang'],$_POST['phuongThucThanhToan'],$_POST['soDienThoaiNhanHang'],$_POST['maNguoiDung'],$_POST['maSanPham']);
        if($order == true){
            echo (json_encode(true)); 
        }
        else{
            echo (json_encode(false)); 
    }
    }   


    function deleteProductAfterOrder($idUser,$idProduct){
        global $connectDb;
        $check = getIdCart($idUser);
        if(sizeof($check) > 0){
            $sqls = "DELETE FROM productincart  WHERE maGioHang = '".$check[0]['maGioHang']."' AND maSanPham = '".$idProduct."'  ";
            $rss = mysqli_query($connectDb,$sqls);
            if($rss){
                return true;
            }
            else return false;
           
        }
        else return false;
    }

    if(isset($_POST['maNguoiDung']) && isset($_POST['maSanPham']) && isset($_POST['action']) && $_POST['action'] == "deleteProductAfterOrder"){
        $check = deleteProductAfterOrder($_POST['maNguoiDung'],$_POST['maSanPham']);
        if($check == true){
            echo (json_encode(true)); 
        }
        else{
            echo (json_encode(false)); 
    }

}



function getIdOrderWait($idUser,$idProduct){
    global $connectDb;
    $sqls = "SELECT * FROM bill WHERE maNguoiDung = '".$idUser."' AND maSanPham = '".$idProduct."' AND tinhTrangDonHang = 'wait'  ";
    $rss = mysqli_query($connectDb,$sqls);
    $result = mysqli_fetch_all($rss,MYSQLI_ASSOC);
    return $result;
}



function addProductInBill($idUser,$idProduct,$nameProduct,$price,$soLuong,$imgProduct){
    global $connectDb;
        $check = getIdOrderWait($idUser,$idProduct);
        if(sizeof($check) > 0 ){
            // kiem tra
            $stt= 0;
            while(true){
                $sqlCheck = "SELECT * from productinbill WHERE maDonHang = '".$check[$stt]['maDonHang']."'";
                $rscheck = mysqli_query($connectDb,$sqlCheck);
                $relutCheck = mysqli_fetch_all($rscheck,MYSQLI_ASSOC);
                if(sizeof($relutCheck) == 0){
                    break;
                }
                else $stt++;
            }
            $sqls = "INSERT INTO productinbill (maDonHang, maSanPham, tenSanPham , giaTien, soLuong, imgProduct) VALUES ('".$check[$stt]['maDonHang']."', '".$idProduct."',  '".$nameProduct."', '".$price."', '".$soLuong."', '".$imgProduct."')";
            $rss = mysqli_query($connectDb,$sqls);  
            if($rss){
                return true;    
            }
            else return false;
                   
        }
        else return false;
}

if(isset($_POST['maNguoiDung']) && isset($_POST['maSanPham'])  && isset($_POST['tenSanPham']) && isset($_POST['giaTien']) && isset($_POST['soLuong']) && isset($_POST['imgProduct'])
     && isset($_POST['action']) && $_POST['action'] == "addProductInBill"){
        $check = addProductInBill($_POST['maNguoiDung'],$_POST['maSanPham'],$_POST['tenSanPham'],$_POST['giaTien'],$_POST['soLuong'],$_POST['imgProduct']);
        echo (json_encode($check,JSON_UNESCAPED_UNICODE));  
    }



function getIdBill($idUser){
    global $connectDb;
    $sql = "SELECT * FROM bill WHERE maNguoiDung = '".$idUser."'";
    $rs = mysqli_query($connectDb,$sql);
    $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
    return $result;
}


function getProductInOrder($idUser,$status){
    global $connectDb;
    $check = getIdBill($idUser);
    if(sizeof($check) > 0){
        $arrayRs = array();
        foreach($check as $item){
        $sqls = "SELECT * From productinbill WHERE maDonHang = '".$item['maDonHang']."' AND trangThaiDatHang = '".$status."'  ";
        $rss = mysqli_query($connectDb,$sqls);
        $result = mysqli_fetch_all($rss,MYSQLI_ASSOC);
        if(isset($result[0])){
            array_push($arrayRs,$result[0]);
        }
        }
        return $arrayRs;
    }
}

if(isset($_POST['maNguoiDung']) && isset($_POST['trangThaiDatHang'])  && isset($_POST['action']) && $_POST['action'] == "getProductInOrder"){
    $check = getProductInOrder($_POST['maNguoiDung'],$_POST['trangThaiDatHang']);
    if($check){
        echo (json_encode($check,JSON_UNESCAPED_UNICODE)); 
    }
}


    // huy lich cat toc
    function cancelMeeting($id){
        global $connectDb;
        $table = "barbermeeting";
        $sql = "UPDATE $table SET tinhTrangLichHen = 'false'  WHERE maLichCatToc = '".$id."' ";
        $rs = mysqli_query($connectDb,$sql);
        if($rs){
            return true;
        }
        else return false;
    }
    if(isset($_POST['maLichCatToc']) && isset($_POST['action']) && $_POST['action'] == "cancelMeeting"){
        $check = cancelMeeting(($_POST['maLichCatToc']));
        if($check){
            echo(json_encode(true,JSON_UNESCAPED_UNICODE));
        }
        else  echo(json_encode(false,JSON_UNESCAPED_UNICODE));
       
    }

    function getPost($chuyenMuc){
        global $connectDb;
        $table = "post";
        $sql = "SELECT * FROM $table WHERE chuyenMuc = '".$chuyenMuc."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
    if(isset($_POST['chuyenMuc']) && isset($_POST['action']) && $_POST['action'] == "getPost"){
        $check = getPost(($_POST['chuyenMuc']));
        if($check){
            echo(json_encode($check,JSON_UNESCAPED_UNICODE));
        }
        else  echo(json_encode($check,JSON_UNESCAPED_UNICODE));
       
    }

    function getOnePost($id){
        global $connectDb;
        $table = "post";
        $sql = "SELECT * FROM $table WHERE maBaiViet = '".$id."' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
    if(isset($_POST['maBaiViet']) && isset($_POST['action']) && $_POST['action'] == "getOnePost"){
        $check = getPost(($_POST['maBaiViet']));
        if($check){
            echo(json_encode($check[0],JSON_UNESCAPED_UNICODE));
        }
       
    }
    function searchProduct($name){
        global $connectDb;
        $table = "product";
        $sql = "SELECT * FROM $table WHERE tenSanPham like '%".$name."%' ";
        $rs = mysqli_query($connectDb,$sql);
        $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
        return $result;
    }
    if(isset($_POST['tenSanPham']) && isset($_POST['action']) && $_POST['action'] == "searchProduct"){
        $check = searchProduct(($_POST['tenSanPham']));
        if(sizeof($check) > 1){
            echo(json_encode($check,JSON_UNESCAPED_UNICODE));
        }
       
    }

    //huy don hang
    function destroyOrder($id){
        global $connectDb;
        $table = "bill";
        $sql = "UPDATE $table SET tinhTrangDonHang = 'destroy'  WHERE maDonHang = '".$id."' ";
        $rs = mysqli_query($connectDb,$sql);
        if($rs){
            return true;
        }
        else return false;
    }
    
    function destroyProduct($id){
        global $connectDb;
        $table = "productinbill";
        $sql = "UPDATE $table SET trangThaiDatHang = 'destroy'  WHERE maDonHang = '".$id."' ";
        $rs = mysqli_query($connectDb,$sql);
        if($rs){
            return true;
        }
        else return false;
    }
    if(isset($_POST['maDonHang']) && isset($_POST['action']) && $_POST['action'] == "destroyOrder"){
        $check1 = destroyOrder(($_POST['maDonHang']));
        $check2 = destroyProduct(($_POST['maDonHang']));
        if($check1 && $check2){
            echo(json_encode(true,JSON_UNESCAPED_UNICODE));
        }
        else  echo(json_encode(false,JSON_UNESCAPED_UNICODE));
       
    }

    function getOrder($idOrder){
        global $connectDb;
        $sqls = "SELECT * FROM bill WHERE maDonHang = '".$idOrder."'";
        $rss = mysqli_query($connectDb,$sqls);
        $result = mysqli_fetch_all($rss,MYSQLI_ASSOC);
        return $result;
    
    }

    if(isset($_POST['maDonHang']) && isset($_POST['action']) && $_POST['action'] == "getOrder"){
        $bill = getOrder($_POST['maDonHang']);
        echo(json_encode($bill,JSON_UNESCAPED_UNICODE));
    }
?>