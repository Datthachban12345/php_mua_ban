<?php
$data = [
    'pageTitle' => 'Đăng kí tài khoản',
];
// $kq = getRaw('SELECT * FROM users WHERE id =3 & id =1'  );
// echo '<pre>';
// // xây dựng hàng theo từng hàng
// print_r($kq);
// echo '</pre>';
if(isPost()){
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



    if(empty($errors)){
        $activeToken = sha1(uniqid().time());
        $dataInsert =[
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password'=> password_hash($filterAll['password'],PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus= insert('users',$dataInsert);
        if($insertStatus){
            setFlashData('smg','Đăng kí thành công');
            setFlashData('smg_type','success');
        }


        // redirect('?module=auth&action=login');
    }else{
        setFlashData('smg','vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type','danger');
        setFlashData('errors',$errors);
        setFlashData('old',$filterAll);
        redirect('?module=auth&action=register');
    }
}
$errors = getFlashData('errors');
$old = getFlashData('old');

layouts('header-login',$data);
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');


?>

<div class="row">
    <div class="col-4" style="margin:50px auto;">
        <h2 class = "text-center text-uppercase">Đăng kí tài khoản Users </h2>
        <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
        ?>
        <form action ="" method ="post">
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
            <button type="submit" class ="mg-btn btn btn-primary btn-block">Đăng kí</button>
            <hr>
            <p class="text-center"><a href = "?module=auth&action=login">Đăng nhập tài khoản</a></p>
            
        </form>
    </div>
</div>

<?php 

layouts('footer-login');
?>