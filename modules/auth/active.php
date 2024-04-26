<?php 
$token = filter()['token'];
if(!empty($token)){
    $tokenQuery = oneRaw("SELECT id FROM users WHERE activeToken = '$tokenLogin'");
    echo '<pre>';
    print_r($tokenQuery);
    echo '</pre>';
}
