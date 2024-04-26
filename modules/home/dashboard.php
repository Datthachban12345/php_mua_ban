
<?php
$data = [
    'pageTitle' => 'Trang Dashboard'
];
layouts('header',$data);
$name = 0;
$filterAll = filter();
if(empty($_SESSION['user_id'])){
    redirect('?module=auth&action=login');
}
                                                                                //phần điều hướng đến trang information   
$listUsers = getRaw("SELECT * FROM product ORDER BY id");     

                        
// phần heart
$users = $_SESSION['user_id'];
$array_favourite = oneRaw("SELECT favourite FROM users WHERE id='$users'");
if(isset($array_favourite)){
    $name_favourite = $array_favourite['favourite'];
    $names_favourite = explode(',', $name_favourite);
}


                                                                                // code phân trang
$sql= getRaw('SELECT COUNT(id) as number FROM product ');
$number = $sql[0]['number'];
$page = ceil($number/12);   
$current_page =1;
if(isset($_GET['page'])){
    $current_page = $_GET['page'];
}
$index = ($current_page -1) *10;
$productUsers = getRaw("SELECT * FROM product ORDER BY id  limit ".$index.",10");
// 

                                                                                // phần search
// search theo thể loại
if(!empty($filterAll['category'])) {
    $category = trim($filterAll['category']);
    $sql= getRaw("SELECT COUNT(id) as number FROM product WHERE category LIKE '%".$category."%'");
    $number = $sql[0]['number'];
    $page = ceil($number/12);   
    $current_page =1;
    if(isset($_GET['page'])){
        $current_page = $_GET['page'];
    }
    $name = 'category='.$category;
    $index = ($current_page -1) *10;
    $productUsers = getRaw("SELECT * FROM product WHERE category LIKE '%".$category."%'");
}
// search mục yêu thích
if(!empty($filterAll['favourites'])){
    $favourites = $filterAll['favourites'];
    $array_favourites = oneRaw("SELECT favourite FROM users WHERE id='$favourites'");
    if(!empty($array_favourites['favourite'])){

        // mục phân trang

        $name_favourites = $array_favourites['favourite'];
        $name_favourites = rtrim($name_favourites, ',');
        $sql = getRaw("SELECT COUNT(*) as number FROM product WHERE id IN ($name_favourites)");
        $number = $sql[0]['number'];
        $page = ceil($number/12);   
        $current_page =1;
        if(isset($_GET['page'])){
            $current_page = $_GET['page'];
        }
        $index = ($current_page -1) *10;
        $name = 'favourites='.$_SESSION['user_id'];

// mục sắp xếp tên
        $productUsers = getRaw("SELECT * FROM product WHERE id IN ($name_favourites)");
    }else{
        $productUsers ="";
    }
}

// search Rating
if(!empty($filterAll['rating'])){
    $ratings = $filterAll['rating'];
    $array_ratings = getRaw("SELECT DISTINCT product_id FROM rating WHERE customer_id='$ratings'");
    $name_ratings = '';
    if(empty($array_ratings['product_id'])){
        $sql = getRaw("SELECT COUNT(DISTINCT product_id) as number FROM rating WHERE customer_id='$ratings'");
        $number = $sql[0]['number'];
        $page = ceil($number/12);   
        $current_page =1;
        if(isset($_GET['page'])){
            $current_page = $_GET['page'];
        }
        $index = ($current_page -1) *10;
        $name = 'rating='.$_SESSION['user_id'];
        for($count=0;$count<$number;$count++){
            $name_ratings = $name_ratings.$array_ratings[$count]['product_id'].',';
        }
    
        $name_ratings = rtrim($name_ratings, ',');
        $productUsers = getRaw("SELECT * FROM product WHERE id IN ($name_ratings)");
    }else{
    }
}

// search từ A -> Z và từ Z -> A
if(!empty($filterAll['arrange'])){
    $arrange = $filterAll['arrange'];
    if($arrange == 'small'){
        $sql= getRaw('SELECT COUNT(id) as number FROM product ORDER BY LEFT(nameProduct, 1) ASC ');
        $number = $sql[0]['number'];
        $page = ceil($number/12);   
        $current_page =1;
        if(isset($_GET['page'])){
            $current_page = $_GET['page'];
        }
        $name = 'arrange=small';
        $index = ($current_page -1) *10;
        $productUsers = getRaw(" SELECT * FROM product ORDER BY LEFT(nameProduct, 1) ASC limit ".$index.",10"); 
    }else{
        $sql= getRaw('SELECT COUNT(id) as number FROM product ORDER BY LEFT(nameProduct, 1) DESC ');
        $number = $sql[0]['number'];
        $page = ceil($number/12);   
        $current_page =1;
        if(isset($_GET['page'])){
            $current_page = $_GET['page'];
        }
        $name = 'arrange=large';
        $index = ($current_page -1) *10;
        $productUsers = getRaw("SELECT * FROM product ORDER BY LEFT(nameProduct, 1) DESC limit ".$index.",10");
    }
    
}
// search theo key
$search = 0;
$k = getFlashData('k');
if(!empty($k)){
    $search = 1;
    if(!empty(trim($k))){
        $sql= getRaw("SELECT COUNT(id) as number FROM product WHERE nameProduct LIKE '%".$k."%'");
        $number = $sql[0]['number'];
        $page = ceil($number/12);   
        $current_page =1;
        if(isset($_GET['page'])){
            $current_page = $_GET['page'];
        }
        $index = ($current_page -1) *10;
        $name = 'keyword='.$k;
        $productUsers = getRaw("SELECT * FROM product WHERE nameProduct LIKE '%".$k."%'");
    }
}
?>  
<?php 
    if(empty($productUsers) ):
?>
<div class="container null">
    <div class="null-page">
        <section class="search-item-result_null" role="status">
            <div class="search-empty-result-section">
                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/search/a60759ad1dabe909c46a.png" class="search-empty-result-section__icon">
                <div class="search-empty-result-section__hint">Không tìm thấy sản phẩm bạn cần tìm trong Shop này</div>
            </div>
        </section>
    </div>
</div>
                            
</div>
<?php
    die;
    endif;
?>
<div class="row p-3 mb-2 bg-light text-dark">
    <div class="col-sm-2">
        <div class="container category">
            <h4 class="category_heading"><i class="fa-solid fa-list"></i> Danh mục</h4>
            <div class="list-group">
                <a class="list-group-item list-group-item-action" href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&category=sách">SÁCH</a>
                <a href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&category=game" class="list-group-item list-group-item-action">GAME</a>
                <a href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&category=phim" class="list-group-item list-group-item-action">PHIM</a>
            </div>    
        </div>


    </div>
    <div class="col-sm-10 ">
        <div class="home-filter">
            <span class="home-filter_label">Tìm kiếm theo</span>
            <a href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&favourites=<?php echo $_SESSION['user_id']; ?>" class=""><button class="btn btn-primary home-filter-btn">Danh sách yêu thích</button></a>
            <a href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&rating=<?php echo $_SESSION['user_id']; ?>" class=""><button class="btn btn-primary home-filter-btn">Đánh giá</button></a>
            <button class="btn btn-primary home-filter-btn" data-toggle="tooltip" title="COMING SOON">Best seller</button>
            <div class="select-input">
                <span class="select-input_label">Theo thứ tự
                    <i class="select-input_label-icon fa-sharp fa-solid fa-angle-down"></i>
                    <ul class="select-input_list">
                        <li class="select-input_item">
                            <a href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&arrange=small" class="select-input_link">Từ A - Z</a>
                        </li>
                        <li class="select-input_item">
                            <a href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&arrange=large" class="select-input_link">Từ Z - A</a>
                        </li>
                    </ul>
                </span>
                
            </div>

        </div>
        <!-- phần prouct  -->

        <?php 
                if(!empty($productUsers) && $search == 1){
                    $kq = getRaw("SELECT COUNT(nameProduct) as number FROM product WHERE nameProduct LIKE '%".$k."%'");
                    $numberKq = $kq[0]["number"];
                    echo "KẾT QUẢ TÌM KIẾM:".$k." (".$numberKq." kết quả)";
                }
        ?>
        <div class="home-product">
                        <div class="grid_row">
                                <?php
                                if(!empty($productUsers)):
                                    $count = 0;
                                    foreach($productUsers as $item):
                                        $count++;   
                                ?>
                                <div class="grid-column-2-4">
                                    <a class="card home-product-item" href="<?php echo _WEB_HOST;?>?module=home&action=information&id=
                                    <?php 
                                        echo $item['id'];
                                    ?>">
                                        <img class="card-img-top home-product-item-img" style="background-image:url(<?php echo $item['img'] ?>)">
                                        <div class="card-body">
                                            <h4 class="card-title home-product-item-name"><?php echo $item['nameProduct'] ?></h4>   
                                            <div class="home-product-item-price">
                                                <span class="home-product-item-price-old"><?php echo $item['price'] ?></span>
                                                <span class="home-product-item-price-new"><?php echo $item['priceNew'] ?></span>
                                            </div>
                                            <div class="home-product-item_action">
                                                <?php 
                                                $a = 0;
                                                for($count = 0;$count < count($names_favourite, COUNT_RECURSIVE)-1;$count++){
                                                    $favourite_name = $names_favourite[$count];
                                                    if($favourite_name == $item['id']):
                                                        $a = 1;
                                                        $heart = '<i class="fa-solid fa-heart"></i>';
                                                        
                                                    ?>
                                                    <div class="home-product-item-favourite">
                                                        <i class="fa-solid fa-check"></i>
                                                        Yêu thích
                                                    </div>
                                                    <?php
                                                    endif;
                                                }
                                                if($a == 0 ){
                                                    $heart = '<i class="fa-regular fa-heart"></i>'; 
                                                }
                                                ?>
                                                <span class="home-product-item-like"><?php echo $heart ?>
                                                    <!-- <i class="fa-solid fa-heart"></i>  -->
                                                </span>
                                                <div class="home-product-item-rating">
                                                <?php
                                                $ccc = $item['id'];
                                                $sumRating = oneRaw("SELECT AVG(stars) as sum FROM rating WHERE product_id='$ccc'");
                                                if(empty($sumRating)){
                                                    $sumRating = 0;
                                                }
                                                $sumRatingss = $sumRating['sum'];
                                                $sumRatings = round($sumRatingss);
                                                    for($count =1;$count<=5;$count++):
                                                        if($count <= $sumRatings){
                                                            $color = '#ffcc00';
                                                        }else{
                                                            $color = '#ccc';                                    
                                                        }
                                                        ?>
                                                        <i class="home-product-item-rating-gold home-product-item-rating-gold2 fa-solid fa-star" style="color:<?php echo $color ?>;"></i>
                                                    <?php
                                                        endfor;
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                </div>
                                <?php 
                                        endforeach;
                                        endif;
                                ?>

                        </div>
        </div>
        <!-- phần pagination -->
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" name  href="#">Previous</a></li>
            <?php
                if($name == 0){
                for ($i= 1;$i<= $page;$i++){
                    echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                }
            }else{
                for ($i= 1;$i<= $page;$i++){
                    echo '<li class="page-item"><a class="page-link" href="?module=home&action=dashboard&'.$name.'&page'.$i.'">'.$i.'</a></li>';
                }
            }
            ?>

            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </div>
</div>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php
layouts('footer');
?> 