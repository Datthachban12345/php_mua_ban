<?php
$data = [
    'pageTitle' => 'Thêm tài khoản',
];
// $kq = getRaw('SELECT * FROM users WHERE id =3 & id =1'  );
// echo '<pre>';
// // xây dựng hàng theo từng hàng
// print_r($kq);
// echo '</pre>';
if(!isPost()){
    $filterAll = filter();
    $errors = [];
    if(empty($filterAll['fullname'])){
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập';
}else{
    if(strlen($filterAll['fullname']) < 5){
    $errors['fullname']['min'] = 'Họ tên bắt buộc có 5 kí tự';
}}

// Email
    if(empty($filterAll['email'])){
        $errors['email']['required'] = 'Email bắt buộc phải nhập';
}else{
    $email = $filterAll['email'];
    $sql = "SELECT id FROM users WHERE email ='$email'";
    if(getRows($sql)>0){
        $errors["email"]["unique"] = "Email đã tồn tại";
    }
}

// phàn Phone
    if(empty($filterAll['phone'])){
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
}else{
    if(!isPhone($filterAll['phone'])){
        $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ';
    }    
}
// phần password
    if(empty($filterAll['password'])){
        $errors['password']['required'] = 'mật khẩu bắt buộc phải nhập';
    }else{
    if(strlen($filterAll['password']) < 8 ){
        $errors['password']['min'] = 'mật khẩu phải lớn hơn hoặc bằng 8';
    }

}
// password cònirm

    if(empty($filterAll['password_confirm'])){  
        $errors['password_confirm']['required'] = 'mật khẩu bắt buộc phải nhập';
    }else{
        if($filterAll['password'] != $filterAll['password_confirm']){
            $errors['password_confirm']['match'] = 'mật khẩu nhập lại không đúng';
        }
     }
     //img

     if(isset($filterAll['fullname'])){
        $hinhanhpath = basename($_FILES['img']['name']);
        $target_dir = "templates/image/";   
        $target_file = $target_dir.$hinhanhpath;
        if( move_uploaded_file($_FILES["img"]["tmp_name"],$target_file)){
            echo 'hình đã upload';
        }else{
            echo 'không lưu được';
        }
    }
    if(empty($errors)){ 
        $dataInsert =[
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password'=> password_hash($filterAll['password'],PASSWORD_DEFAULT),
            'status' => $filterAll['status'],
            'create_at' => date('Y-m-d H:i:s'),
            'img' => $hinhanhpath,
        ];
        $insertStatus= insert('users',$dataInsert);
        if($insertStatus){
            setFlashData('smg','Thêm người dùng thành công');
            setFlashData('smg_type','success');
        }else{
            setFlashData('smg','Thêm người dùng thất bại');
            setFlashData('smg_type','danger');
        }


        redirect('?module=users&action=list');
    }else{
        setFlashData('smg','vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type','danger');
        setFlashData('errors',$errors);
        setFlashData('old',$filterAll);
        redirect('?module=users&action=add');
    }
}
$errors = getFlashData('errors');
$old = getFlashData('old');

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
layouts('header-login',$data);

?>

<div class="container">
    <div class="row" style="margin:50px auto;">
        <h2 class = "text-center text-uppercase">Thêm người dùng </h2>
        <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
        ?>
        <form action ="" method ="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="from-group mg-form">
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
                            <input name="email" type = "email" class="form-control" placeholder = "địa chỉ email" value="<?php 
                            echo (!empty($old['email'])) ? $old['email'] : null;
                            ?>">
                            <span class="error">
                            <?php 
                                if(!empty($errors['email'])){
                                    $errors_email = implode(' ',$errors['email']);
                                    echo $errors_email;
                                }
                            ?></span>
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
                        <label for="">Password</label>
                        <input name="password" type = "password" class="form-control" placeholder = "Mật khẩu" >
                        <span class="error">
                        <?php 
                            if(!empty($errors['password'])){
                                $errors_pass = implode(' ',$errors['password']);
                                echo $errors_pass;
                            }
                        ?></span>
                        </div>

                        <div class="from-group mg-form">
                        <label for="">Nhập lại Password</label>
                        <input name ="password_confirm" type = "password" class="form-control" placeholder = "Nhập lại mật khẩu" >
                        <span class="error">
                        <?php 
                            if(!empty($errors['password_confirm'])){
                                $errors_pass_confirm = implode(' ',$errors['password_confirm']);
                                echo $errors_pass_confirm;
                            }
                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="" >Trạng thái</label>
                            <select name="status" id="" class="form-control" >
                                <option value="0" <?php echo(old('status',$old) == 0) ? 'selected' : false; ?>>Chưa kích hoạt</option>
                                <option value="1" <?php echo(old('status',$old) == 1) ? 'selected' : false; ?>>Đã kích hoạt</option>
                            </select>
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

            </div>


            <button type="submit" class ="mg-btn users btn btn-primary btn-block">Thêm người dùng</button>
            <a href="?module=users&action=list" type="submit" class ="mg-btn users btn btn-success btn-block">Quay lại</a>
            <hr>
            
            
        </form>
    </div>
</div>
<?php
layouts('footer-login');
?>