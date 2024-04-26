<?php
$data = [
    'pageTitle' => 'Quản sản phẩm'
];
layouts('header-login',$data);

$listUsers = getRaw("SELECT * FROM product ORDER BY id");

//  $errors = getFlashData('errors');
//  $old = getFlashData('old');
 
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>
<div class="container">
    <hr>
    <h2>Quản lí sản phẩm</h2>
    <p>
        <a href="?module=users&action=add_product" class="btn btn-success btn-sm">Thêm sản phẩm <i class="fa-solid fa-plus"></i></a>
        <a href="?module=users&action=add_category" class="btn btn-success btn-sm">Thêm thể loại <i class="fa-solid fa-plus"></i></a>
    </p>
    <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
    ?>
    <table class="table table-bordered">
        <thead >
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>img</th>
            <th>giá cũ</th>
            <th>giá mới</th>
            <th>Thông tin sản phẩm</th>
            <th>Thể loại</th>
            <th width= 5%>Sửa</th>
            <th width=5%>Xóa</th>
        </thead>
        <tbody>
            <?php
            if(!empty($listUsers)):
                $count = 0;
                foreach($listUsers as $item):
                    $count++;
            ?>
        <tr>
            <td><?php echo $count;?></td>
            <td><?php echo $item['nameProduct'];?></td>
            <td><img class="card-img-top home-product-item-img" style="background-image:url(<?php echo $item['img'] ?>)"></td>
            <td><?php echo $item['price'];?></td>
            <td><?php echo $item['priceNew'];?></td>
            <td><?php echo $item['describes'];?></td>
            <td><?php echo $item['category'];?></td>
            <td><a href="<?php echo _WEB_HOST;?>?module=users&action=edit_product&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
            <td><a href="<?php echo _WEB_HOST;?>?module=users&action=delete_product&id=<?php echo $item['id']; ?>"onclick ="return confirm('Bạn chắc chắn muốn xóa chứ')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>

        </tr>
             
        <?php 
                endforeach;
            else:
        ?>
            <tr>
                <td colspan="7">
                    <div class="alert alert-danger text-center">Không có sản phầm nào</div>
                </td>
            </tr>
        <?php 
            endif;
        ?>
        </tbody>
    </table>
</div>

<?php
layouts('footer-login');
?>
