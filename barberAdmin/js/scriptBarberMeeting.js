$(document).ready(function () {
    checkBabermeeting()
    function viewData() {
        $.post('data.php', function (response) {
            $('#bodyMeeting').html(response);
        })
    }

    function checkBabermeeting(){
        var action = "checkDay"
        $.ajax({
            url : 'check.php',
            method : 'post',
            data : {
                action : action
            },
            success : function(){
                viewData()
            }
        })
    }

    $(document).on('click','#button_cancel',function(){
        var check = confirm("Bạn có muốn huỷ lịch cắt không?");
        if (check == true) {
            var id = $(this).val();
            var action = "cancelMeeting"
            $.post('cancelMeeting.php', { maLichCatToc: id, action: action }, function (response) {
          //          $('#noti').html(response)
                    viewData()
             })
         } else return;
    })

    $('#button_filter').on('click', function () {
        var daySelected = $('#filterDay').val() 
        var year = daySelected.substr(0,4)
        var month = daySelected.substr(5,2)
        var day = daySelected.substr(8,2)
        var selected = day + '/' + month + '/' + year
        if(selected == '//'){
            viewData()
        }
        else {
            var action = 'filterBarbermeeting'
            $('#bodyMeeting').html('')
            $.ajax({
                url : 'filterBarbermeeting.php',
                method : 'post',
                data : {
                    ngay : selected,
                    action : action
                },
                success : function(data){
                    $('#bodyMeeting').html(data)
                }
            })
        }
    })

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        if(searchTerm == ''){
            viewData()
        }
        else {
            var action = 'searchUser'
            $('#bodyMeeting').html('')
            $.ajax({
                url : 'search.php',
                method : 'post',
                data : {
                    keySearch : searchTerm,
                    action : action
                },
                success : function(data){
                    $('#bodyMeeting').html(data)
                }
            })
        }
    })
})