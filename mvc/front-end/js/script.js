$(document).ready(function () {
    // Gọi sự kiện click khi click nút Thêm vào giỏ
    // Ctrl + Shift + R để xóa cache trình duyệt
    $('.add-to-cart').click(function() {
        event.preventDefault();
        // LẤy id sản phẩm từ chính đối tượng vừa click
        var id = $(this).attr('data-id');
        console.log(id);
        // Gọi ajax để nhờ PHP xử lý thêm vào giỏ
        $.ajax({
            //url php sẽ xử lý ajax
            url: 'index.php?controller=cart&action=add',
            //phương thức truyền dữ liệu
            method: 'GET',
            // dữ liệu gửi lên
            data: {
                id: id
            },
            // nơi nhận kết quả trả về sau khi php thực
            //hiện xử lý xong ajax
            success: function(data) {
                // console.log(data);
                // Hiển thị thông báo Thêm vào giỏ hàng
                //thành công
                $('.ajax-message')
                    .html('Add product successfully');
                // Thêm class để show ra message
                $('.ajax-message')
                    .addClass('ajax-message-active');
                // Show message trong 3s, sau đó tự ẩn đi
                setTimeout(function() {
                    $('.ajax-message')
                        .removeClass('ajax-message-active');
                }, 3000);
                // Tăng số lượng sản phẩm trong giỏ lên 1
                var amount = $('.flaticon-shopping-cart').html();
                //cắt bỏ khoảng trắng 2 đầu
                amount = amount.trim();
                // Tăng lên 1
                amount++;
                // Gán lại giá trị đã tăng cho số lượng ban đầu
                $('.flaticon-shopping-cart').html(amount);
            }
        });
    })
    $('#province').change(function() {
        // event.preventDefault();
        var provinceID = $('#province').val();
        console.log(provinceID);
        $.post('views/payments/district.php',{'provinceid':provinceID},function(data) {
            $('#district').html(data);
        },'text');
    })
});