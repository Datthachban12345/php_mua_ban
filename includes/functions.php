<?php
// tạo hàm dùng chung để gõ cho nhanh
// hàm layouts ở đây để viết tắt require_once
function layouts($layoutName='header', $data=[]){
    if(file_exists(_WEB_PATH_TEMPLATES.'/layout/'.$layoutName.'.php')){
        
        // Hàm sẽ trả về True nếu file, thư mục truyền vào tồn tại. Ngược lại hàm sẽ trả về False..
        require_once _WEB_PATH_TEMPLATES.'/layout/'.$layoutName.'.php';
    }
}
function isGet(){
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        return true;
    }
    return false;
}
function isPost(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        return true;
    }
    return false;
}
// check xem có chèn thêm kí hiệu lạ ko vd như <sript> chả hạn
function filter(){
    if(isGet()){
        if(!empty($_GET)){
            foreach($_GET as $key => $value){
                $key = strip_tags($key);
                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }else {
                    $filterArr[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
                }
              
}

    }}
    if(isPost()){
        if(!empty($_POST)){
            foreach($_POST as $key => $value){
                $key = strip_tags($key);
                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }else {
                    $filterArr[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
                }
}

    }}
    return $filterArr;
}

function isEmail($email){
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;

}

function isNumberInt($number){
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}
function isNumberFloat($number){
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}
function isPhone($phone){
    $checkZero = false;
    if($phone[0] == '0' ){
        $checkZero = true;
        $phone = substr($phone,1);
    }
    $checkNumber = false;
    if(isNumberInt($phone) && (strlen($phone) == 9)){
        $checkNumber = true;
    }
    if($checkZero && $checkNumber){
        return true;
    }
    return false;
}

// hàm thông báo lỗi đăng kí    
function getSmg($smg, $type =''){
    echo '<div class ="alert alert-'.$type.'">';
    echo $smg;
    echo '</div>';
    
}


// hàm chuyển hướng
function redirect($path=''){
    header("Location:  $path");
    exit;
}

function form_error($fileName, $beforeHtml='',$afterHtml= '',$errors){
    return (!empty($errors['fullname'])) ? '<span class="error">'.reset($errors['fullname']).'</span>':null;
}

// hàm hiển thị dữ liệu cũ
function old($fileName,$oldData,$default = null){
    return (!empty($oldData[$fileName])) ? $oldData[$fileName] : $default;
}

// hàm kiểm tra trạng thái daneg nhập
function isLogin(){
    $checkLogin = false;
    if(getSession('logintoken')){
        $tokenLogin = getSession('logintoken');
        $queryToken = oneRaw("SELECT user_Id FROM logintoken WHERE token ='$tokenLogin' ");
        if(!empty( $queryToken )){
            $checkLogin = true;
        }else{
            removeSession('logintoken');
        }
}
    return $checkLogin;
}

