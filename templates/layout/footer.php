<script src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src = "<?php echo _WEB_HOST_TEMPLATES;?>/js/bootstrap.min.js"></script>
<script src = "<?php echo _WEB_HOST_TEMPLATES;?>/js/custom.js"></script>






<footer class="footer">
    <div class="grid1">
        <div class="grid_row grid_row1">
            <div class="grid_column-2-4">
                <h3 class="footer_heading">Chăm sóc khách hàng</h3>
                <ul class="footer-list">
                    <li class="footer-item">
                        <a href="" class="footer-item_link">Trung tâm trợ giúp</a>
                        <a href="" class="footer-item_link">Facebook</a>
                        <a href="" class="footer-item_link">Ý kiến hỏi đáp</a>
                    </li>
                </ul>
            </div>
            <div class="grid_column-2-4">
                <h3 class="footer_heading">Giới thiệu</h3>
                <ul class="footer-list">
                    <li class="footer-item">
                        <a href="" class="footer-item_link">Giới thiệu</a>
                        <a href="" class="footer-item_link">Điều khoản sử dụng</a>
                        <a href="" class="footer-item_link">Tuyển dụng</a>
                    </li>
                </ul>
            </div>
            <div class="grid_column-2-4">
                <h3 class="footer_heading">Theo dõi</h3>
                <ul class="footer-list">
                    <li class="footer-item">
                        <a href="" class="footer-item_link"><i class="footer-item_link-icon fa-brands fa-facebook"></i> Facebook</a>
                        <a href="" class="footer-item_link"><i class="footer-item_link-icon fa-brands fa-instagram"></i> Instagram</a>
                        <a href="" class="footer-item_link"><i class="footer-item_link-icon fa-brands fa-linkedin"></i> Linkedin</a>
                    </li>
                </ul>
            </div>
            <div class="grid_column-2-4">
                <h3 class="footer_heading">Danh mục</h3>
                <ul class="footer-list">
                    <li class="footer-item">
                        <a href="" class="footer-item_link">Ảnh anime</a>
                        <a href="" class="footer-item_link">Game </a>
                        <a href="" class="footer-item_link">Manga</a>
                    </li>
                </ul>
            </div>
            <div class="grid_column-2-4">
                <h3 class="footer_heading">Vào Web trên ứng dụng</h3>
                <div class="footer_download">
                    <img src="https://f8ubuntu.online/assets/img/qr_code.png" alt="" class="footer_download-qr">
                    <div class="footer_download-apps">
                        <img src="templates/image/android1.png" alt="" class="footer_download-chplay">
                        <img src="templates/image/appstore1.png" alt="" class="footer_download-appstore">
                    </div>
                </div>
                <ul class="footer-list">

                </div>
                </ul>
            </div>
        </div>
        <div class= "grid_row2">
            <p class="footer_text">2024 - Bản quyền thuộc về Đạt</p>
        </div>
    </div>
</footer>
<script>
	function remove_background(product_id)
		{
		for(var count = 1; count <= 5; count++)
			{
			    $('#'+product_id+'-'+count).css('color', '#ccc'); 
			}
		}
		//hover chuột đánh giá sao
	$(document).on('mouseenter', '.rating', function(){
		var index = $(this).data("index"); //3
		var product_id = $(this).data('product_id'); //13
						
		remove_background(product_id);
		for(var count = 1; count<=index; count++)
			{
				$('#'+product_id+'-'+count).css('color', '#ffcc00');
			}
	});
					  //nhả chuột ko đánh giá
	$(document).on('mouseleave', '.rating', function(){
	    var index = $(this).data("index");
		var product_id = $(this).data('product_id');
		var stars = $(this).data("stars");
		remove_background(product_id);
		for(var count = 1; count<=stars; count++)
		{
			$('#'+product_id+'-'+count).css('color', '#ffcc00');
		}
	});

</script>
<script>
	$('.rating').click(function(){
        
		var index = $(this).data("index"); //3
		var product_id = $(this).data('product_id');
		var customer_id = $(this).data('customer_id');
		$.ajax(
		    { url: 'ajax/rating.php',
			data: {index:index, product_id:product_id, customer_id:customer_id},
			type: 'POST',
			success: function(data) {
										
				alert('Đánh giá '+index+' sao thành công');
			}
			});
	    })
        
</script>