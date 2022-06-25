$(document).ready(function () {
    viewData()
    function viewData() {
        $.post('data.php', function (response) {
            $('#bodyOrder').html(response);
        })
    }

    $(document).on('click','#button_comfirm',function(){
        var check = confirm("Xác nhận đơn hàng?");
        if (check == true) {
            var id = $(this).val();
            var action = "comfirmOrder"
            $.post('comfirm.php',{maDonHang : id, action : action},function(response){
                $('#noti').html(response)
                viewData()
            })
        } else return;
    })

    $(document).on('click','#btndestroy',function(){
        var check = confirm("Huỷ đơn hàng?");
        if (check == true) {
            var id = $(this).val();
            var action = "destroyOrder"
            $.post('destroy.php',{maDonHang : id, action : action},function(response){
                $('#noti').html(response)
                
                viewData()
            })
        } else return;
    })
})