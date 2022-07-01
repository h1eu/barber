$(document).ready(function () {
    viewData()
    function viewData() {
        $.post('data.php', function (response) {
            $('#bodyPost').html(response);
        })
    }
    $('#button_insert').on('click', function () {
        var chuyenMuc = $('#typePost').val();
        var tieuDe = $('#titlePost').val()
        var noiDung = $('#contentPost').val()
        var img = $('#imgPost').val()
 
    
        if (chuyenMuc == '' || tieuDe == '' || tieuDe == '' || noiDung == ''  ) {
            alert('Không được bỏ trống');
        }
        else if(img == ''){
            var action = "addPost"
            var formData = new FormData()
            formData.append('chuyenMuc', chuyenMuc);
            formData.append('tieuDe', tieuDe);
            formData.append('noiDung', noiDung);
            formData.append('action', 'addPost');
            $.ajax({
                url: "addPost.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                complete: function (data) {                    
                        alert("Thêm thành công");
                        $('#typePost').val("")
                        $('#titlePost').val("")
                        $('#contentPost').val("")
                        $('#imgPost').val("")
                        $('#button_cancel').click();
                        viewData();                    
                }
            })
        }
        else {
            var action = "addPost"
            var formData = new FormData()
            formData.append('chuyenMuc', chuyenMuc);
            formData.append('tieuDe', tieuDe);
            formData.append('noiDung', noiDung);
            formData.append('action', 'addPost');
            formData.append('img', $('input[type=file]')[0].files[0])
            $.ajax({
                url: "addPost.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                complete: function (data) {                    
                    if(data['responseText'] == "Không được upload ảnh lớn hơn 8mb.")
                    {
                        alert(data['responseText'])
                    }
                    else if(data['responseText'] == "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF"){
                        alert(data['responseText'])
                    }
                    else{
                        alert("Thêm thành công");
                        $('#titlePost').val("")
                        $('#contentPost').val("")
                        $('#imgPost').val("")
                        $('#button_cancel').click();
                        viewData();
                    }
                    
                }
            })
         }
    });
    $(document).on('click','#button_delete',function(){
        var check = confirm("Bạn có muốn xoá không?");
        if (check == true) {
            var id = $(this).val();
            var action = "deletePost"
            $.post('deletePost.php',{maBaiViet : id, action : action},function(response){
             //   $('#noti').html(response)
                viewData()
            })
        } else return;
    })

    var idPost = -1
    var tieudeOld = ''
    var noiDungOld = ''

    $(document).on('click','#btnEdit',function(){
        var id = $(this).val();
        idPost = id
        var action = "getBaiViet"
        // $('#updateProductName').prop('disabled', 'disabled');
         $('#updateTypePostx').prop('disabled', 'disabled');
         $('#updateImgPost').prop('disabled', 'disabled');
         
        $.ajax({
            url: "editPost.php",
            type: "GET",
            
            data: {
                maBaiViet: idPost,
                action: action
            },
            dataType: "json",
            success: function (response) {
                $('#updateTypePost').val(response['chuyenMuc'])
                $('#updateTitlePost').val(response['tieuDe'])
                $('#updateContentPost').val(response['noiDung'])              
            //    $('#updateImgPost').val(response['imgPost'])
                $('#updatePostImg').attr('src',response['imgPost'])
                tieudeOld = $('#updateTitlePost').val()
                noiDungOld = $('#updateContentPost').val()

            }
        })
        $('#UpdateModal').modal("show")
    })

    function updatePost(idPost,tieudeOld,noiDungOld){
        var action2 = "updatePost"
        var tieuDeNew = $('#updateTitlePost').val()
        var noiDungNew = $('#updateContentPost').val()
        if(tieuDeNew == tieudeOld &&  noiDungNew == noiDungOld){
            alert("chưa cập nhật")
        }
        else if(tieuDeNew == '' || noiDungNew ==''){
            alert("Không được để trống")
        }
        else{
            $.ajax({
                url: "editPost.php",
                type: "POST",
                data: {
                    maBaiViet : idPost,
                    tieuDeNew : tieuDeNew,
                    noiDungNew : noiDungNew,
                    action : action2
                } , 
                complete : function(response){
                    console.log(tieudeOld)
                    console.log(noiDungOld)
                    alert("Cập nhật thông tin cho bài viết thành công");
                    $('#button_close').click();
                    viewData();
                }
            })
        }
        
    }

    $(document).on('click', '#button_save',function(e){
        e.preventDefault();
        updatePost(idPost,tieudeOld,noiDungOld)
    })

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        if(searchTerm == ''){
            viewData()
        }
        else {
            var action = 'searchPost'
            $('#bodyPost').html('')
            $.ajax({
                url : 'search.php',
                method : 'post',
                data : {
                    keySearch : searchTerm,
                    action : action
                },
                success : function(data){
                    $('#bodyPost').html(data)
                }
            })
        }
    })
    $('#button_filter').on('click', function () {
        var typePostSelected = $('#typePostSelected').val() 
        if(typePostSelected == ''){
            viewData()
        }
        else {
            var action = 'filterPost'
            $('#bodyPost').html('')
            $.ajax({
                url : 'filterPost.php',
                method : 'post',
                data : {
                    chuyenMuc : typePostSelected,
                    action : action
                },
                success : function(data){
                    $('#bodyPost').html(data)
                }
            })
        }
    })
})