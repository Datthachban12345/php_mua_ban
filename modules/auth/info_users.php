<?php
$data = [
    'pageTitle' => 'Thông tin tài khoản',
];
// $kq = getRaw('SELECT * FROM users WHERE id =3 & id =1'  );
// echo '<pre>';
// // xây dựng hàng theo từng hàng
// print_r($kq);
// echo '</pre>';
$filterAll = filter();
if(!empty($filterAll['id'])) {
    $userId = $_SESSION['user_id'];
    // kiểm tra xem userID có tồn rại không
    // sau đó sử lí tồn tại hay không tồn tại
    $userDetail = oneRaw("SELECT * FROM users WHERE id ='$userId'");
    if(!empty($userDetail)) {
        setFlashData("user-detail",$userDetail);
    }else{
        redirect('?module=error&action=404');
    }
}
if(isPost()){
    $filterAll = filter();
    $errors = [];
    if(empty($filterAll['fullname'])){
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập';
}else{
    if(strlen($filterAll['fullname']) < 5){
    $errors['fullname']['min'] = 'Họ tên bắt buộc có 5 kí tự';
}}



// phàn Phone
    if(empty($filterAll['phone'])){
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
}else{
    if(!isPhone($filterAll['phone'])){
        $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ';
    }    
}
    if(!empty($filterAll['password'])){
        if(empty($filterAll['password_confirm'])){  
            $errors['password_confirm']['required'] = 'mật khẩu bắt buộc phải nhập';
        }else{
            if($filterAll['password'] != $filterAll['password_confirm']){
                $errors['password_confirm']['match'] = 'mật khẩu nhập lại không đúng';
            }
        }
    }
    
    if(isset($filterAll['fullname'])){
        $hinhanhpath = basename($_FILES['img']['name']);
        $target_dir = "templates/image/";   
        $target_file = $target_dir.$hinhanhpath;
        if( move_uploaded_file($_FILES["img"]["tmp_name"],$target_file)){
            $a=2;
        }else{
            $a=1;
        }
    }
    if(empty($errors)){ 
        $dataUpdate =[
            'fullname' => $filterAll['fullname'],
            'phone' => $filterAll['phone'],
            'create_at' => date('Y-m-d H:i:s'),
            'img' => $hinhanhpath,
        ];

        if(!empty($filterAll['password'])){
            $dataUpdate['password'] = password_hash($filterAll['password'], PASSWORD_DEFAULT);

        }
        $condition = "id = $userId";
        $insertStatus= update('users',$dataUpdate,$condition);
        if($insertStatus){
            setFlashData('smg','Sửa người dùng thành công');
            setFlashData('smg_type','success');
        }else{
            setFlashData('smg','Sửa người dùng thất bại! Vui lòng sửa lại');
            setFlashData('smg_type','danger');
        }


        
    }else{
        setFlashData('smg','vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type','danger');
        setFlashData('errors',$errors);
        setFlashData('old',$filterAll);
    }
}
$errors = getFlashData('errors');
$old = getFlashData('old');
$userDetaill = getFlashData('user-detail');
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
layouts('header',$data);

if(!empty($userDetaill)){
    $old = $userDetaill;
}

?>

<div class="container">
    <div class="row" style="margin:50px auto;">
        <h2 class = "text-center text-uppercase">Sửa thông tin người dùng </h2>
        <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
        ?>
        <form action ="" method ="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="from-group mg-form" >
                            <label for="">Họ và tên</label>
                            <input name = "fullname" type = "fullname" class="form-control" placeholder = "Họ và tên" value="<?php 
                            echo old('fullname',$old);
                            ?>">
                            <?php 
                                echo form_error('fullname','<span class = "error">','</span>',$errors);
                            ?>
                            </div>
                        <div class="from-group mg-form">
                            <label for="">Email</label>
                            <input name="email" type = "email" class="form-control" value="<?php 
                            echo (!empty($old['email'])) ? $old['email'] : null;
                            ?>" aria-label="Disabled input example" disabled readonly>
                        </div>
                    <div class="from-group mg-form">
                            <label for="">Số điện thoại</label>
                            <input name="phone" type = "number" class="form-control" placeholder = "Nhập SĐT" value="<?php 
                            echo (!empty($old['phone'])) ? $old['phone'] : null;
                            ?>">
                            <span class="error">
                            <?php 
                                if(!empty($errors['phone'])){
                                    $errors_phone = implode(' ',$errors['phone']);
                                    echo $errors_phone;
                                }
                            ?></span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="from-group mg-form">
                        <label for="">Password(Nếu muốn đổi mk thì sửa lại)</label>
                        <input name="password" type = "password" class="form-control" placeholder = "Mật khẩu không nhập nếu không thay đổi" >
                        <span class="error">
                        <?php 
                            if(!empty($errors['password'])){
                                $errors_pass = implode(' ',$errors['password']);
                                echo $errors_pass;
                            }
                        ?></span>
                        </div>

                    <div class="from-group mg-form">
                        <label for="">Nhập lại Password(Nếu muốn đổi mk thì sửa lại)</label>
                        <input name ="password_confirm" type = "password" class="form-control" placeholder = "Nhập lại mật khẩu (không nhập nếu không thay đổi)" >
                        <span class="error">
                        <?php 
                            if(!empty($errors['password_confirm'])){
                                $errors_pass_confirm = implode(' ',$errors['password_confirm']);
                                echo $errors_pass_confirm;
                            }
                        ?></span>
                        </div>

                    <div class="mb-3 from-group mg-form">
                        <label for="formFile"  class="form-label">Gửi ảnh vào đây</label>
                        <input class="form-control" name= "img" type="file" id="formFile" value="<?php 
                        echo (!empty($old['img'])) ? $old['img'] : null;
                        ?>">
                        <span class="error">
                            <?php 
                                if(!empty($errors['img'])){
                                    $errors_img = implode(' ',$errors['img']);
                                    echo $errors_img;
                            }
                        
                        ?></span>
                    </div>  

            </div>

            <input type="hidden" name="id" value="<?php echo $userId; ?>">

            <button type="submit" class ="mg-btn users btn btn-primary btn-block">Sửa người dùng</button>
            
            <hr>
            
            
        </form>
    </div>
</div>

<?php 

layouts('footer-login');
?>