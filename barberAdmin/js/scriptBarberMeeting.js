$(document).ready(function () {
    viewData()
    function viewData() {
        $.post('data.php', function (response) {
            $('#bodyMeeting').html(response);
        })
    }

    $(document).on('click','#button_cancel',function(){
        var check = confirm("Bạn có muốn huỷ lịch cắt không?");
        if (check == true) {
            var id = $(this).val();
            var action = "cancelMeeting"
            $.post('cancelMeeting.php', { maLichCatToc: id, action: action }, function (response) {
                    $('#noti').html(response)
                    viewData()
             })
         } else return;
    })

})