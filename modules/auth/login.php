<?php 

$data = [
    'pageTitle' => 'Đăng nhập tài khoản'
];
layouts('header-login',$data);


if(isPost()){
    $filterAll = filter();
    if(!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))){
        $email = $filterAll['email'];
        $password = $filterAll['password'];

        // truy vấn lấy tông tin users theo 
        $userQuery = oneRaw("SELECT password, id FROM users WHERE email='$email'");
        if(!empty($userQuery)){
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if(password_verify($password,$passwordHash)){
                // tạo token login

                $userLogin = getRows("SELECT * FROM logintoken WHERE user_Id='$userId'");
                if($userLogin > 0 ){
                    setFlashData("smg","tài khoản đang đăng nhập ở 1 nơi khác");
                    setFlashData("smg_type","danger");
                    redirect('?module=auth&action=login');
                }

                $tokenLogin = sha1(uniqid().time());
                $dataInsert = [
                    'user_Id' => $userId,
                    'token' => $tokenLogin,
                    'create_at' => date('Y-m-d H:i:s')
                ];
                
                $insertStatus = insert('logintoken',$dataInsert);
                if($insertStatus){
                    setSession('logintoken',$tokenLogin);
                    $_SESSION['user_id'] = $userId;
                    redirect('?module=home&action=dashboard');
                }
                
            }else{
                setFlashData('smg','mật khẩu không chính xác');
                setFlashData('smg_type','danger');
                
            }
       
        }else{
            setFlashData('smg','email không tồn tại');
            setFlashData('smg_type','danger');
            
        }
    }else{
        setFlashData('smg','Vui lòng nhập email và mật khẩu');
        setFlashData('smg_type','danger');
        
    }
    redirect('?module=auth&action=login');
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>
<div class="row">
    <div class="col-4" style="margin:50px auto;">
        <h2 class = "text-center text-uppercase">Đăng nhập quản lí Users </h2>
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
            <div class="from-group mg-form">
                <label for="">Password</label>
                <input name="password" type = "password" class="form-control" placeholder = "Mật khẩu">
            </div>
            <button type="submit" class ="mg-btn btn btn-primary btn-block">Đăng nhập</button>
            <hr>
            <p class="text-center"><a href = "?module=auth&action=forgot">Quên mật khẩu</a></p>
            <p class="text-center"><a href = "?module=auth&action=register">Đăng kí</a></p>
        </form>
    </div>
</div>

<?php 
require_once("templates/layout/footer-login.php")
?>  