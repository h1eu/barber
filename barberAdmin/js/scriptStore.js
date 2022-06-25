$(document).ready(function(){
    viewStore()
    function viewStore() {
        $.post('dataStore.php', function(response){
            $('#bodyStore').html(response);
        })
    }
    $('#button_insert').on('click', function () {
        var address = $('#address_store').val();
        if (address == '') {
            alert('Không được bỏ trống');
        } else {
            $.ajax({
                url: "addStore.php",
                type: "POST",
                data: {
                    diaChi: address,
                },
                dataType: 'json',
                complete: function (data) {
                    alert("Thêm thành công");
                    $('#address_store').val("")
                    $('#button_cancel').click();
                    viewStore();
                }
            })
        }
    });
    $(document).on('click','#button_delete',function(){
        var check = confirm("Bạn có muốn xoá không?");
        if (check == true) {
            var id = $(this).val();
            var action = "deleteStore"
            $.post('deleteStore.php',{maCuaHang : id, action : action},function(response){
                $('#noti').html(response)
                viewStore()
            })
        } else return;
    })

    $(document).on('click','#btnEdit',function(){
        var id = $(this).val();
        var action = "getAddress"
        var addressOld = ""
        $.post('editStore.php',{maCuaHang : id,action : action}, function(response){
            $('#address_store_old').val(response)  
            addressOld = $('#address_store_old').val()   
            console.log(addressOld) ; 
        })
        $('#UpdateModal').modal("show")
        $(document).on('click','#button_save',function(){
            var action2 = "updateAddress"
            var addressNew = $('#address_store_old').val()  
           
            if(addressNew == ''  ){
                alert("không được để trống")
            }
            else if(addressOld == addressNew){
                alert("chưa cập nhật địa chỉ")
            }
            else{
                $.post('editStore.php',{
                        maCuaHang : id, 
                        diaChiMoi : addressNew, 
                        action :action2},
                    function(respone){
                    alert("Cập nhật địa chỉ thành công");
                    $('#address_store_old').val("")
                    $('#button_close').click();
                    viewStore();
                })
            }
        })
    })
})