<?php 
$sumProduct = 0;
$data = [
    'pageTitle' => 'Giỏ hàng'
];
$idd_product = getFlashData('idd_product');
layouts('header',$data);
$id_user = $_SESSION['user_id'];
$cartUsers = getRaw("SELECT * FROM cart WHERE id_user='$id_user'");


?>
<section class="cart">
    <div class="container">
        <div class="cart-top-warp">
            <div class="cart-top">
                <div class="cart-top-cart cart-top-item">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="cart-top-adress cart-top-item">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="cart-top-payment cart-top-item">
                    <i class="fa-solid fa-money-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="cart-content row">
            <div class="cart-content-left col">
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Màu</th>
                        <th>SL</th>
                        <th>Thành tiền</th>
                        <th>Tổng tiền</th>
                        <th>Xóa</th>
                    </tr>
                    <tbody>
                        <?php
                        if(!empty($cartUsers)):
                            foreach($cartUsers as $item):
                                $idItem = $item['product_id'];

                                $productUsers = getRaw("SELECT * FROM product WHERE id ='$idItem'");
                                foreach($productUsers as $itemProduct):
                        ?>
                    <tr>
                        <td><img src="<?php echo $itemProduct['img'];?>" alt=""></td>
                        <td><p><?php echo $itemProduct['nameProduct'];?></p></td>
                        <td><img src="https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg" alt=""></td>
                        <td><?php echo $item['quantity'];?></td>
                        <td><p><?php echo $itemProduct['priceNew'];?><sup>đ</sup></p></td>
                        <td><p><?php 
                        $itemProducts_1 = str_replace('.', '',$itemProduct['priceNew']);
                        $sumProduct_1 = (int)$itemProducts_1*(int)$item['quantity'];
                        $format_number_1 = number_format($sumProduct_1,0,".",".");
                        echo $format_number_1;
                        ?></p></td>
                        <td><a href="<?php echo _WEB_HOST;?>?module=home&action=delete_cart&id=<?php
                        echo $item['id_cart']; ?>"onclick ="return confirm('Bạn chắc chắn muốn xóa chứ')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>

                    </tr>
                        
                    <?php
                                    $itemProducts = str_replace('.', '',$itemProduct['priceNew']);
                                    $sumProduct = $sumProduct + (int)$itemProducts*(int)$item['quantity'];
                                    if(empty($itemProducts)){

                                    }
                                    $format_number = number_format($sumProduct,0,".",".");
                                endforeach; 
                            endforeach;
                        else:
                    ?>
                        <tr>
                            <td colspan="7">
                                <div class="alert alert-danger text-center">Không có giỏ hàng nào</div>
                            </td>
                        </tr>
                    <?php 
                        endif;
                    ?>
                    </tbody>

                </table>
            </div>
            <div class="cart-content-right col">
                <table>
                    <tr>
                        <th colspan="2">TỔNG TIỀN GIỎ HÀNG</th>
                    </tr>
                    <tr>
                        <td>TỔNG SẢN PHẨM</td>
                        <td><?php
                        $grossProduct = oneRaw("SELECT COUNT(DISTINCT product_id) as gross FROM cart WHERE id_user='$id_user'");
                        echo $grossProduct['gross'];
                        ?></td>
                    </tr>
                    <tr>
                        <td>TỔNG TIỀN HÀNG</td>
                        <td><p><?php
                        if(!empty($format_number)){
                            echo $format_number;
                        }else{
                            echo "0";
                        }
                        ?><sup>đ</sup></p></td>
                    </tr>
                    <tr>
                        <td>TẠM TÍNH</td>
                        <td><p style="color:black;font-weight:bold;"><?php
                        if(!empty($format_number)){
                            echo $format_number;
                        }else{
                            echo "0";
                        }
                        ?><sup>đ</sup></p></td>
                    </tr>
                </table>
                <div class="cart-content-right-text">
                    <p>Bạn sẽ miễn phí ship</p>
                    <p style="color:red;font-weight:bold;">Mua thêm <span style="font-size:18px;">131.000đ</span> để được free ship</p>
                </div>
                <div class="cart-content-right-button">
                    <a href="<?php echo _WEB_HOST;?>?module=home&action=information&id=<?php
                    
                    echo $idd_product;?>" class=""><button>TIẾP TỤC MUA SẮM</button></a>
                    <button>THANH TOÁN</button>
                </div>
                <div class="cart-content-right-login">
                    <p>TÀI KHOẢN IVY</p>
                    <p>Hãy <a href="">Đăng nhập</a>tài khoản của bạn để tích lũy thành viên</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
layouts('footer',$data);
?>