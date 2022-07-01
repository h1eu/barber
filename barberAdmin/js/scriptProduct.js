$(document).ready(function () {
    viewData()
    function viewData() {
        $.post('dataProduct.php', function (response) {
            $('#bodyProduct').html(response);
        })
    }
  

    $('#button_insert').on('click', function () {
        var name = $('#productName').val();
        var price = $('#productPrice').val()
        var typeProduct = $('#productType').val()
        var img = $('#productImg').val()
        var des = $('#productDes').val()
 
     //  var desDiv = $('#desDiv').children().eq(1).children().eq(1).children().eq(1).children().eq(1).contents().children().eq(0).children().eq(1).html()
        if (name == '' || price == '' || price == '' || typeProduct == '' || img == '' || des == '') {
            alert('Không được bỏ trống');
        }
        else {
            var action = "addProduct"
            var formData = new FormData()
            formData.append('tenSanPham', name);
            formData.append('giaTien', price);
            formData.append('loai', typeProduct);
            formData.append('moTa', des);
            formData.append('action', 'addProduct');
            formData.append('img', $('input[type=file]')[0].files[0])
            $.ajax({
                url: "addProduct.php",
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
                        $('#productName').val("")
                        $('#productPrice').val("")
                        $('#productType').val("")
                        $('#productDes').val("")
                        $('#productImg').val("")
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
            var action = "deleteProduct"
            $.post('deleteProduct.php',{maSanPham : id, action : action},function(response){
         //       $('#noti').html(response)
                viewData()
            })
        } else return;
    })

    var priceOld = ""
    var idProduct = -1

    $(document).on('click','#btnEdit',function(){
        var id = $(this).val();
        idProduct = id
        var action = "getProduct"
        $('#updateProductName').prop('disabled', 'disabled');
        $('#updateProductType').prop('disabled', 'disabled');
        $('#updateProductImg').prop('disabled', 'disabled');
        $.ajax({
            url: "editProduct.php",
            type: "GET",
            data: {
                maSanPham: idProduct,
                action: action
            },
            dataType: "json",
            success: function (response) {
                $('#updateProductName').val(response['tenSanPham'])
                $('#updateProductPrice').val(response['giaTien'])
                $('#updateProductType').val(response['loai'])              
     //           $('#updateProductImg').val(response[0]['imgProduct'])
                $('#updateproductDes').val(response['moTa'])
                $('#updateProductImgSrc').attr('src',response['imgProduct'])
                console.log(response['moTa'])
               
                priceOld =  $('#updateProductPrice').val()
            }
        })
        $('#UpdateModal').modal("show")
       
    })

    function updateProduct(idProduct,priceOld){
        var action2 = "updateProduct"
        var priceNew = $('#updateProductPrice').val()
        if(priceOld == priceNew){
            alert("chưa cập nhật giá tiền sản phẩm")
        }
        else if(priceNew == ''){
            alert("Không được để trống")
        }
        else{
            $.ajax({
                url: "editProduct.php",
                type: "POST",
                data: {
                    maSanPham : idProduct,
                    giaTien : priceNew,
                    action : action2
                } , 
                complete : function(response){
                    alert("Cập nhật giá cho sản phẩm thành công");
                    // $('#updateHairStore').val("")
                    $('#button_close').click();
                    viewData();
                }
            })
        }
    }

    $(document).on('click', '#button_save',function(e){
        e.preventDefault();
        updateProduct(idProduct,priceOld)
    })

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        if(searchTerm == ''){
            viewData()
        }
        else {
            var action = 'searchProduct'
            $('#bodyStore').html('')
            $.ajax({
                url : 'search.php',
                method : 'post',
                data : {
                    keySearch : searchTerm,
                    action : action
                },
                success : function(data){
                    $('#bodyProduct').html(data)
                }
            })
        }
    })
    
    $('#button_filter').on('click', function () {
        var typeProductSelected = $('#typeProductSelected').val() 
        if(typeProductSelected == ''){
            viewData()
        }
        else {
            var action = 'filterProduct'
            $('#bodyProduct').html('')
            $.ajax({
                url : 'filterProduct.php',
                method : 'post',
                data : {
                    loai : typeProductSelected,
                    action : action
                },
                success : function(data){
                    $('#bodyProduct').html(data)
                }
            })
        }
    })
})