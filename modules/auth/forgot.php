<?php 

$data = [
    'pageTitle' => 'Quên mật khẩu'
];
layouts('header-login',$data);

if(isLogin()){
    redirect('?module=home&action=dashboard');
}

if(isPost()){
    $filterAll = filter();
    if(!empty($filterAll['email'])){
        $email = $filterAll['email'];
        $queryUser = oneRaw("SELECT id FROM users WHERE email = '$email'");
        // if(!empty($queryUser)){
        //     $userId = $queryUser["id"];
        //     $forgotToken = sha1(uniqid().time());
        //     $dataUpdate = [
        //         'forgotToken' => $forgotToken,
        //     ];
        //     $updateStatus = update('users',$dataUpdate,"id = $userId");
        //     if($updateStatus){
        //         $linkReset = _WEB_HOST.'?module=auth&action=reset&token='.$forgotToken;

        //         $subject = 'Yêu cầu khôi phục mật khẩu';
        //         $content = 'Chào bạn.</br>';
        //         $content .= 'Khôi phục mật khẩu';
        //         $content .= $linkReset.'</br>';
        //         $content .= 'Trân trọng cảm ơn';
        //         $sendEmail = sendMail($email, $subject, $content);
        //         if($sendEmail){
        //             setFlashData('smg','Vui lòng kiểm tra email');
        //             setFlashData('smg_type','success');
        //         }else{
        //             setFlashData('smg','Vui lòng thử lại sau');
        //             setFlashData('smg_type','danger');
        //         }
        //     }
        }else{
            setFlashData('smg','Địa chỉ email không tồn tại trong hệ thống');
            setFlashData('smg_type','danger');
        }
    }else{
        setFlashData('smg','Vui lòng nhập địa chỉ email');
        setFlashData('smg_type','danger');
        
    }
    // redirect('?module=auth&action=forgot');

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>
<div class="row">
    <div class="col-4" style="margin:50px auto;">
        <h2 class = "text-center text-uppercase">Quên mật khẩu</h2>
        <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
        ?>
        <form action ="" method ="post">
            <div class="from-group mg-form">
                <label for="">Email</label>
                <input name="email" type = "email" class="form-control" placeholder = "địa chỉ email">
            </div>
            <button type="submit" class ="mg-btn btn btn-primary btn-block">Gửi</button>
            <hr>
            <p class="text-center"><a href = "?module=auth&action=login">Đăng nhập</a></p>
            <p class="text-center"><a href = "?module=auth&action=register">Đăng kí</a></p>
        </form>
    </div>
</div>

<?php 
require_once("templates/layout/footer-login.php")
?>  