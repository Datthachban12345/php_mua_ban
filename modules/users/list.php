
<?php 
$data = [
    'pageTitle' => 'Danh sách người dùng',
];
layouts('header-login',$data);
$listUsers = getRaw("SELECT * FROM users ORDER BY update_at");

//  $errors = getFlashData('errors');
//  $old = getFlashData('old');
 
 $smg = getFlashData('smg');
 $smg_type = getFlashData('smg_type');
?>
<div class="container">
    <hr>
    <h2>Quản lí người dùng</h2>
    <p>
        <a href="?module=users&action=add_users" class="btn btn-success btn-sm">Thêm người dùng <i class="fa-solid fa-plus"></i></a>
    </p>
    <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
    ?>
    <table class="table table-bordered">
        <thead >
            <th>STT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Trạng thái</th>
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
            <td><?php echo $item['fullname'];?></td>
            <td><?php echo $item['email'];?></td>
            <td><?php echo $item['phone'];?></td>
            <td><?php echo $item['status'] == 1 ? '<button class= "btn btn-success btn-sm">Đã kích hoạt</button>' : '<button class= "btn btn-danger btn-sm">Chưa kích hoạt</button>';?></td>
            <td><a href="<?php echo _WEB_HOST;?>?module=users&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
            <td><a href="<?php echo _WEB_HOST;?>?module=users&action=delete&id=<?php echo $item['id']; ?>"onclick ="return confirm('Bạn chắc chắn muốn xóa chứ')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>

        </tr>
             
        <?php 
                endforeach;
            else:
        ?>
            <tr>
                <td colspan="7">
                    <div class="alert alert-danger text-center">Không có người dùng nào</div>
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
