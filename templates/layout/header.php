
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($data['pageTitle'])  ? $data['pageTitle'] : 'Quản lí người dùng' ?></title>
    <link rel = "stylesheet" href ="<?php echo _WEB_HOST_TEMPLATES ?> /css/bootstrap.min.css">
    <link rel = 'stylesheet' href ="<?php echo _WEB_HOST_TEMPLATES ?> /css/style.css?ver=<?php echo rand()?>">
    <link rel = 'stylesheet' href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
  </head>
<body>

  <?php 
  if(isset($_GET['keyword'])){
      $filterAll = filter();
      if(!empty(trim($filterAll['keyword']))){
          $k = $filterAll['keyword'];
          setFlashData('k',$k);
    }
  }
  $id_user = $_SESSION['user_id'];
  $image = oneRaw("SELECT img FROM users WHERE id ='$id_user'");
  $images = $image['img'];
  
  ?>

  <header class="p-3 mb-3 border-bottom">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <!-- <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
          </a> -->

          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="?module=home&action=dashboard" class="nav-link px-2 link-secondary">Trang chủ</a></li>
            <li><a href="?module=home&action=cart" class="nav-link px-2 link-body-emphasis">Giỏ hàng</a></li>
            <li><a href="#" class="nav-link px-2 link-body-emphasis" data-toggle="tooltip" title="COMING SOON">Khách hàng</a></li>
            <!-- <li><a href="#" class="nav-link px-2 link-body-emphasis">Sản phẩm</a></li> -->
          </ul>

          <form  class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" method="GET">
            <input type="search" name="keyword" class="form-control" placeholder="Search..." aria-label="Search" 
            value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" >

          </form>

          <div class="dropdown text-end">
            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?php
              if(isset($images)){
              echo 'templates/image/'.$images;
              }else{
                echo 'templates/image/co-4-la-may-man-avatar-dep-34.jpg';
              }
              
              ?>" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small">
              <li><a class="dropdown-item" href="<?php echo _WEB_HOST;?>?module=auth&action=info_users&id=
                                    <?php 
                                        echo $_SESSION['user_id'];
                                    ?>">Tài khoản của tôi</a></li>
              <li><a class="dropdown-item" href="#">Đơn mua</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="?module=auth&action=logout">Đăng xuất</a></li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>
