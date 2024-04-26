<?php
const _HOST = "127.0.0.1";
const _DB = "php_first";
const _USER = 'root';
CONST _PASS = '';

try {
    if(class_exists('PDO')){
        $dsn = 'mysql:dbname=' ._DB.';host='._HOST;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            // set utf8
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            // tạo thông báo khi gặp lỗi
        ];
        $conn = new PDO($dsn,_USER,_PASS,$options);
    }
}catch(Exception $exception){
    echo '<div style="color:red; padding:5px 15px;border:1px solid red;">';
    echo $exception ->getMessage(),'<br>';
    echo '</div>';
    die();
}

$filepath = realpath(dirname(__FILE__));
include_once($filepath.'/../includes/database.php');
if(isset($_POST['index'])){
        $product_id = $_POST['product_id'];
        $stars = $_POST['index'];
        $customer_id = $_POST['customer_id'];
        $sql = "INSERT INTO rating(product_id,stars,customer_id) VALUES(:product_id,:stars,:customer_id)";
        $statement = $conn -> prepare($sql);
        $statement -> bindParam(':product_id',$product_id);
        $statement -> bindParam(':stars',$stars);
        $statement -> bindParam(':customer_id',$customer_id); 

        $insertStatus = $statement -> execute();


}
