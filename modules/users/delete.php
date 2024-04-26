<?php
$filterAll = filter();
if(!empty($filterAll['id'])){
    $userId = $filterAll['id'];
    $userDetail = getRaw("SELECT * FROM users WHERE id='$userId'");
    if($userDetail > 0 ){
        $deletetoken = delete('logintoken',"user_id=$userId");
        if($deletetoken){
            $deleteUser = delete('users',"id = $userId");
            if( $deleteUser ){
                setFlashData("smg","Xóa người dùng thành công");
                setFlashData("smg_type","success");
            }else{
                setFlashData("smg","Lỗi hệ thống");
                setFlashData("smg_type","danger");
            }
        }
    }else{
        setFlashData('smg','Không có người đùng tồn tại');
        setFlashData('smg_type','danger');
    }
}else{
    setFlashData('msg','Liên kết không tồn tại');
    setFlashData('msg_type','danger');
}
redirect('?module=users&action=list');

