<?php 
include_once('../../../db/config.php');
$db = new db();
try {
    $connectDb = $db->connectDB();
} catch (PDOException $e) {
    echo "lỗi kết nối: " . $e->getMessage();
}

function getNgay(){
    global $connectDb;
    $table = "barbermeeting";
    $sql = "SELECT * FROM $table";
    $rs = mysqli_query($connectDb,$sql);
    $result = mysqli_fetch_all($rs,MYSQLI_ASSOC);
    return $result;
}


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
function checkDay(){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time = date("H:i");
    $day = date("d/m/Y");
    $monthC = substr($day,3,2);
    $dayC = substr($day,0,2);
    $hourC = substr($time,0,2);
    $minusC = substr($time,3,2);
    $listDay = getNgay();
    foreach($listDay as $item){
        $monthS = substr($item['ngay'],3,2);
        $dayS = substr($item['ngay'],0,2);
        $hourS = substr($item['gio'],0,2);
        $minusS = substr($item['gio'],3,2);
        $c = strcmp($monthS,$monthC);
        if($c < 0){
            cancelMeeting($item['maLichCatToc']);
        }
        else if ($c == 0){
            $cc = strcmp($dayS,$dayC);
            if($cc < 0){
                cancelMeeting($item['maLichCatToc']);
            }
            else if ($cc == 0){
                $checkTime =  strcmp($hourS,$hourC);
                if($checkTime < 0){
                    cancelMeeting($item['maLichCatToc']);
                }
                else if ( $checkTime == 0){
                    $timeC = $minusC + 15;
                    $checkMinus = strcmp($minusS,$timeC);
                    if($checkMinus < 0){
                        cancelMeeting($item['maLichCatToc']);
                    }
                }
            }
        }
    }
}

if(isset($_POST['action']) && $_POST['action'] == "checkDay"){
    $check = checkDay();
}


?>