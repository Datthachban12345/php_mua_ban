
<!--  Tất cả các dữ liệu mà Client gửi lên bằng phương thức GET đều được lưu trong một biến toàn cục mà PHP tự tạo ra đó là biến $_GET
  -->
<?php 
session_start();
require_once('config.php');
require_once('./includes/connect.php');
require_once('./includes/functions.php');
require_once('./includes/database.php');
require_once('./includes/session.php');

// chay project nao thi can khoi tao session cho 

// cai nay giong 

// echo '<i class="fa-solid fa-magnifying-glass"></i>';
// $session_test = setSession('troll','troll vn');
// var_dump($session_test);
$module = _MODULE;
$action = _ACTION;

if(!empty($_GET['module']))
{
    if(is_string($_GET['module']))
    {
        $module = trim($_GET['module']);
    }
}

if(!empty($_GET['action']))
{
    if(is_string($_GET['action']))
    {
        $action = trim($_GET['action']);
    }
}


$path = 'modules/'. $module. '/' . $action. '.php';

if(file_exists($path)){
    // file_exists kiểm tra file toòn tại hay ko
    require_once($path);
}else {
    require_once 'modules\error\404.php' ;
}

