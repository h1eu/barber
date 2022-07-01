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
                //    $('#noti').html(response)
                    viewData()
             })
         } else return;
    })


    var idHairdresser = -1
    var idStoreOld = ""

    $(document).on('click', '#btnEdit', function () {
        var id = $(this).val();
        idHairdresser = id 
        var action = "getHairdresser"
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
                $('#updateHairImg').attr('src',response[0]['img'])
                idStoreOld =  $('#updateHairStore').val()
            }
        })
        $('#UpdateModal').modal("show") 
    })

   

    function updatehairdresser(idHairdresser,idStoreOld){
        var action2 = "updateHairdresser"
        var idStoreNew = $('#updateHairStore').val()
        if(idStoreOld == idStoreNew){
            alert("chưa cập nhật địa chỉ")
        }
        else{
            $.ajax({
                url: "editHairdresser.php",
                type: "POST",
                data: {
                    maThoCatToc : idHairdresser,
                    maCuaHangNew : idStoreNew,
                    action : action2
                } , 
                complete : function(response){
                    alert("Cập nhật địa chỉ làm việc thành công");
                    $('#updateHairStore').val("")
                    $('#button_close').click();
                    viewData();
                }
            })
        }
        
    }

    $(document).on('click', '#button_save',function(e){
        e.preventDefault();
        updatehairdresser(idHairdresser,idStoreOld)
    })

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        if(searchTerm == ''){
            viewData()
        }
        else {
            var action = 'searchHairdresser'
            $('#bodyHairdresser').html('')
            $.ajax({
                url : 'search.php',
                method : 'post',
                data : {
                    keySearch : searchTerm,
                    action : action
                },
                success : function(data){
                    $('#bodyHairdresser').html(data)
                }
            })
        }
    })

    $('#button_filter').on('click', function () {
        var idStoreSeleted = $('#idStoreSelected').val() 
        if(idStoreSeleted == ''){
            viewData()
        }
        else {
            var action = 'filterHairdresser'
            $('#bodyHairdresser').html('')
            $.ajax({
                url : 'filterHairdresser.php',
                method : 'post',
                data : {
                    idStore : idStoreSeleted,
                    action : action
                },
                success : function(data){
                    $('#bodyHairdresser').html(data)
                }
            })
        }
    })
    
})
