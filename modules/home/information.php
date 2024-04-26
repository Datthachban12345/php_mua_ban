<?php 
$filterAll = filter();
$users = $_SESSION['user_id'];
if(!empty($filterAll['id'])) {
    $userId = $filterAll['id'];
    $_SESSION['old'] = $userId;
    $userDetail = oneRaw("SELECT * FROM product WHERE id ='$userId'");
    if(!empty($userDetail)) {
        setFlashData("user-detail",$userDetail);
    }
}else{
    $old = $_SESSION['old'];
    $userId = (int)$old;
    $userDetail = oneRaw("SELECT * FROM product WHERE id ='$userId'");
    if(!empty($userDetail)) {
        setFlashData("user-detail",$userDetail);
    }
}
// category
$categoryy = oneRaw("SELECT category FROM product WHERE id ='$userId'");
$category = $categoryy['category'];
$array_category = explode(',', $category);


// RATING
$sumRating = oneRaw("SELECT AVG(stars) as sum FROM rating WHERE product_id='$userId'");
if(empty($sumRating)){
    $sumRating = 0;
}
$sumRatingss = $sumRating['sum'];
$sumRatings = round($sumRatingss);
$sumRatingsss = round($sumRatingss,1);
$sumPeople = oneRaw("SELECT COUNT(id) as peo FROM rating WHERE product_id='$userId'");
$sumPeoples = $sumPeople['peo'];
if($sumPeoples > 999 and $sumPeoples < 1000000){
    $sumPeoples = $sumPeoples/1000;
    $sumPeoples = round($$sumPeoples,1);
    $sumPeoples = (string)$sumPeoples.'k';
}
if($sumPeoples>= 1000000){
    $sumPeoples = $sumPeoples/1000000;
    $sumPeoples = ceil($$sumPeoples);
    $sumPeoples = (string)$sumPeoples.'TR';
}

// favourite

$array_favourite = oneRaw("SELECT favourite FROM users WHERE id='$users'");
if(isset($array_favourite)){
    $name_favourite = $array_favourite['favourite'];
    $names_favourite = explode(',', $name_favourite);
}

$a = 0;
    for($count = 0;$count < count($names_favourite, COUNT_RECURSIVE)-1;$count++){
        $favourite_name = $names_favourite[$count];
        if($favourite_name == $userId){
            $a = 1;
            $value_favourite = 'delete';
            $heart = '<i class="fa-solid fa-heart"></i>';
            
        }
    }
    if($a == 0 ){
        $value_favourite = $userId;
        $heart = '<i class="fa-regular fa-heart"></i>'; 
    }

// button yêu thích
if(isset($_POST['button_favourite'])){
    if(isNumberInt($value_favourite)){
        $users_id = $_SESSION['user_id'];
        $condition = "id = $users_id";
        $data = $userId.",";
        if(empty($name_favourite)){
            $dataUpdate =[
                'favourite' => html_entity_decode($data),
            ];
            $insertStatus= update('users',$dataUpdate,$condition);
            $heart = '<i class="fa-solid fa-heart"></i>';
        }else{
            $editStatus= edit('users','favourite',$data,$condition);
            $heart = '<i class="fa-solid fa-heart"></i>';
        }

    }else{
        $users_id = $_SESSION['user_id'];
        $condition = "id = $users_id";
        $data = $userId.",";
        $editStatus= editDelete('users','favourite',$data,$condition);
        $heart = '<i class="fa-regular fa-heart"></i>';
    }
    }

// thêm vào giỏ hàng
if(isset($_POST['button_cart'])){
    
    $dataInsert =[
        'product_id' => $userId,
        'quantity' => $filterAll['quantity'],
        'id_user' => $_SESSION['user_id'],

    ];
    $insertStatus= insert('cart',$dataInsert);

    if($insertStatus){
        setFlashData('smg','Đăng kí thành công');
        setFlashData('smg_type','success');
        redirect('?module=home&action=cart');
        setFlashData('old',$filterAll);
        
    }else{
        setFlashData('smg','vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type','danger');
        setFlashData('old',$filterAll);
    }
}
$user = getFlashData('user-detail');
$nameProduct = $user['nameProduct'];


$name = html_entity_decode($user['describes']);
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$data = [
    'pageTitle' => $nameProduct
];
layouts('header',$data);
?>
<div class = "text-dark">
<section class="product">
    <div class="container">
        <div class="product-top">
            <a href="?module=home&action=dashboard" class="category-home_page category-product">Trang chủ</a>
            <?php
            for($count = 0;$count < count($array_category, COUNT_RECURSIVE);$count++):
                $category_name = $array_category[$count];
            ?>
            <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/productdetailspage/966fbe37fe1c72e3f2dd.svg" alt="icon arrow right" class="icon-arrow_right">
            
            <a class="category-product" href="<?php echo _WEB_HOST;?>?module=home&action=dashboard&category=
            <?php 
                echo $category_name;
            ?>"><?php echo $category_name;?></a>
            <?php
            endfor;
            ?>
        </div>
        <div class="product-content row">
            <div class="product-content-left row">
                <div class="product-content-left-big-img">
                    <img src="<?php echo $user['img'] ?>" alt="" class="">
                </div>
                <div class="product-content-left-small-img">
                    <img src="<?php echo $user['img'] ?>" alt="">
                    <img src="https://gcs.tripi.vn/public-tripi/tripi-feed/img/474053HcM/anh-anime-phong-canh-hiem-sieu-dep_103543078.jpg" alt="">
                    <img src="https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg" alt="">
                </div>
            </div>
            <div class="product-content-right">
                <div class="product-content-right-product-name">
                    <h1><?php echo $user['nameProduct'] ?></h1>
                </div>
                <div class="product-content-right-product-favourite">
                <form action ="" method ="post" class="form-favourite">
                                    <input type="hidden" name="favourite" value="<?php
                                            echo $value_favourite;
                                        ?>                                                                   
                                    ">
                                    <button type="submit" name="button_favourite" class ="users btn button-favourite"><?php echo $heart;?></button>
                                    <div class="comment-favourite">Yêu thích</div>
                                </form>
                </div>
                <div class="product-content-right-product-price">
                    <p><?php echo $user['price'] ?><sup>đ</sup></p>
                    <p><?php echo $user['priceNew'] ?><sup>đ</sup></p>
                </div>
                    <div class="product-content-right-product-color">
                    <p>GIẢM <?php 
                        $price = str_replace('.', '', $user['price']);
                        $priceNew = str_replace('.', '', $user['priceNew']);
                        $sumPrice = 100-(((float)$priceNew/(float)$price)*100);
                        $sumPriceNew = (int)$sumPrice;
                        echo $sumPriceNew.'%';
                    ?></p>
                </div>
                <div class="product-content-right-product-size ">
                    <p style="font-weight:bold;">Đánh giá</p>
                    <div class="evaluate">
                        <ul class="evaluate-star header_navbar-item--separate list-inline">
                            <li class="evaluate-star-number"><?php echo $sumRatingsss?></li>
                            <?php
                            for($count =1;$count<=5;$count++):
                                if($count <= $sumRatings){
                                    $color = '#ffcc00';
                                }else{
                                    $color = '#ccc';                                    
                                }
                                ?>
                                <li class="rating" title ="đánh giá sao" style="cursor:pointer; color:<?php echo $color ?>;font-size:25px;" 
                                id ="<?php echo $user['id'];?>-<?php echo $count; ?>"  data-index ="<?php echo $count; ?>" data-product_id="<?php echo $user['id'];?>" data-stars="<?php echo $sumRatings?>" data-customer_id = "<?php echo $_SESSION['user_id']; ?>">
                                &#9733;

                            <?php
                                endfor;
                                ?>
                            </li>
                        </ul>
                        <button class="evaluate-people text-dark">
                            <div class="evaluate-people-number"><?php echo $sumPeoples;?></div>
                            <p>Đánh giá</p>
                        </button>  

                    </div>

                </div>
                <form action="" method ="post">
                    <div class="quantity">
                        <p style="font-weight:bold">số lượng</p>
                        <input name="quantity" type="number" min=1 value="1">
                    </div>
                    <div class="product-content-right-product-button">
                        <a href="<?php
                        setFlashData('idd_product',$user['id']);
                        echo _WEB_HOST;?>?module=home&action=cart"><button name="button_cart" class = "product-content-right-product-button-button" type="submit"><i class="fa-solid fa-cart-shopping"></i><p>Mua hàng</p></button></a>
                        <!-- <button class = "product-content-right-product-button-button" data-bs-toggle="modal" data-bs-target="#myModal" type ="submit"><p>Thêm vào giỏ hàng</p></button> -->
                    </div>
                </form>
                <!-- <div class="modal" id="myModal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                        Modal Header
                            <div class="modal-header">
                                <i class="auth-form_close-icon fa-solid fa-circle-check"></i>
                            </div>

                             Modal body
                            <div class="modal-body">
                                Thêm vào giỏ hàng thành công!
                            </div>

                             Modal footer

                        </div>
                    </div>
                </div> -->
                <div class="product-content-right-product-icon">
                    <div class="product-content-right-product-icon-item">
                        <i class="fa-solid fa-phone"></i><p>Hotline</p>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fa-regular fa-comment"></i><p>Chat</p>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fa-regular fa-envelope"></i><p>Mail</p>
                    </div>
                </div>
                <div class="product-content-right-product-QR">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/330px-QR_code_for_mobile_English_Wikipedia.svg.png" alt="">
                </div>
                <div class="product-content-right-bottom">
                    <div class="product-content-right-bottom-top">
                        &#8744;
                    </div>
                    <div class="product-content-right-bottom-content-big">
                        <div class="product-content-right-bottom-content-title row">
                            <div class="product-content-right-bottom-content-title-item chitiet col-sm-2">
                                <p>Chi tiết</p>
                            </div>
                            <div class="product-content-right-bottom-content-title-item baoquan col-sm-4">
                                <p>Thông tin sản phầm</p>
                            </div>      
                        </div>
                        <div class="product-content-right-bottom-content">
                            <div class="product-content-right-bottom-content-chitiet">
                                <?php echo $name ?>
                            </div>
                            <div class="product-content-right-bottom-content-baoquan">
                                mọi người
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-related container">
    <div class="product-related-title">
        <p>Sản phẩm liên quan</p>
    </div>
    <div class="product-content">
        <?php 
        $num = 0;
        for($count=0;$count< count($array_category, COUNT_RECURSIVE );$count++):
            $related_products = getRaw("SELECT * FROM product WHERE (id <> '$user[id]') AND (category LIKE '%".$array_category[$count]."%')");
            foreach($related_products as $item):
                $num++;
                if($num > 6){
                    break;
                }
        ?>
         <div class="product-related-item col-sm-2">
            <a class="card home-product-item" href="<?php echo _WEB_HOST;?>?module=home&action=information&id=
                <?php 
                    echo $item['id'];
                ?>">
                <img class="home-product-item-img" style="background-image:url(<?php echo $item['img']; ?>)" alt="">
                <h4 class="card-title home-product-item-name"><?php echo $item['nameProduct']; ?></h4>
                <span class="home-product-item-price-new"><?php echo $item['priceNew']; ?><sup>đ</sup></span>
            </a>
        </div>
        <?php
        endforeach;
    endfor;
    if($num <6):
        $num = 6 - $num;
        $related_productss = getRaw("SELECT * FROM product WHERE (category LIKE '%tô màu%') LIMIT $num");
        foreach($related_productss as $item):
        ?>
        <div class="product-related-item col-sm-2">
            <a class="card home-product-item" href="<?php echo _WEB_HOST;?>?module=home&action=information&id=
            <?php 
                echo $item['id'];
            ?>">
                <img class="home-product-item-img" style="background-image:url(<?php echo $item['img']; ?>)" alt="">
                <h4 class="card-title home-product-item-name"><?php echo $item['nameProduct']; ?></h4>
                <span class="home-product-item-price-new"><?php echo $item['priceNew']; ?><sup>đ</sup></span>
            </a>
        </div>
        <?php 
                endforeach;
            endif;
        ?>
        </div>


</section>
</div>
<!-- thêm vào giỏ hàng thành công -->


<script>        
    // phần nào là ảnh to
    const bigImg = document.querySelector(".product-content-left-big-img img")
    const smallImg = document.querySelectorAll(".product-content-left-small-img img")
    smallImg.forEach(function(imgItem,X){
        imgItem.addEventListener("mouseover",function(){
            bigImg.src = imgItem.src
        })  
    })

// phần nào đc hiển thị
    const baoquan = document.querySelector(".baoquan")
    const chitiet = document.querySelector(".chitiet")
    if(baoquan){
        baoquan.addEventListener("click",function(){           
            document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "none"
            document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "block"
        })
    }
    if(chitiet){
        chitiet.addEventListener("click",function(){
            document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "block"
            document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "none"
        })
    }
    const butTon = document.querySelector(".product-content-right-bottom-top")
    if(butTon){
        butTon.addEventListener("click",function(){
        document.querySelector(".product-content-right-bottom-content-big").classList.toggle("activeB")

        })
    } 
</script>

<?php 
layouts('footer');
?>
