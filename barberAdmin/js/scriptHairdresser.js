$(document).ready(function () {
    viewData()
    function viewData() {
        $.post('dataHairdresser.php', function (response) {
            $('#bodyHairdresser').html(response);
        })
    }

    $('#button_insert').on('click', function () {
        var name = $('#hairName').val();
        var age = $('#hairAge').val()
        var listHair = $('#hairListHair').val()
        var avt = $('#hairAvt').val()
        var idStore = $('#hairStore').val()
        if (name == '' || age == '' || listHair == '' || avt == '' || idStore == '') {
            alert('Không được bỏ trống');
        }
        else {
            var action = "addHairdresser"
            var formData = new FormData()
            formData.append('tenThoCatToc', name);
            formData.append('tuoi', age);
            formData.append('kieuTocChinh', listHair);
            formData.append('maCuaHang', idStore);
            formData.append('action', 'addHairdresser');
            formData.append('img', $('input[type=file]')[0].files[0])
            $.ajax({
                url: "addHairdresser.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                complete: function (data) {                    
                    if(data['responseText'] == "Dữ liệu không đúng cấu trúc"){
                        alert(data['responseText'])
                    }
                    else if(data['responseText'] == "Không được upload ảnh lớn hơn 8mb.")
                    {
                        alert(data['responseText'])
                    }
                    else if(data['responseText'] == "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF"){
                        alert(data['responseText'])
                    }
                    else{
                        alert("Thêm thành công");
                        $('#hairName').val("")
                        $('#hairAge').val("")
                        $('#hairListHair').val("")
                        $('#hairAvt').val("")
                        $('#hairStore').val("")
                        $('#button_cancel').click();
                        viewData();
                    }
                    
                }
            })
        }
    });

    $(document).on('click', '#button_delete', function () {
        var check = confirm("Bạn có muốn xoá không?");
        if (check == true) {
            var id = $(this).val();
            var action = "deleteHairdresser"
            $.post('deleteHairdresser.php', { maThoCatToc: id, action: action }, function (response) {
                    $('#noti').html(response)
                    viewData()
             })
         } else return;
    })

    $(document).on('click', '#btnEdit', function () {
        var id = $(this).val();
        var action = "getHairdresser"
        $idStoreOld = ""
        $.ajax({
            url: "editHairdresser.php",
            type: "GET",
            data: {
                maThoCatToc: id,
                action: action
            },
            dataType: "json",
            success: function (response) {
                $('#updateHairName').val(response[0]['tenThoCatToc'])
                $('#updateHairAge').val(response[0]['tuoi'])
                $('#updateHairListHair').val(response[0]['kieuTocChinh'])
                $('#updateHairAvt').prop('disabled', 'disabled');
                $('#updateHairStore').val(response[0]['maCuaHang'])
                $idStoreOld =  $('#updateHairStore').val()
                console.log($idStoreOld)
            }
        })
        $('#UpdateModal').modal("show")
        $(document).on('click', '#button_save',function(){
            var action2 = "updateHairdresser"
            $idStoreNew = $('#updateHairStore').val()
            console.log($idStoreNew)
            console.log(id )
            if($idStoreOld == $idStoreNew){
                alert("chưa cập nhật địa chỉ")
            }
            else{
                $.ajax({
                    url: "editHairdresser.php",
                    type: "POST",
                    data: {
                        maThoCatToc : id,
                        maCuaHangNew : $idStoreNew,
                        action : action2
                    } , 
                    complete : function(response){
                        alert("Cập nhật địa chỉ thành công");
                        $('#updateHairStore').val("")
                        $('#button_close').click();
                        viewData();
                    }
                })
            }
            
        })
        
    })
})
