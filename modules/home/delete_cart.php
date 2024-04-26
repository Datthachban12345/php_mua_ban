<?php
$filterAll = filter();
if(!empty($filterAll['id'])){
    $userId = $filterAll['id'];
    $userDetail = getRaw("SELECT * FROM cart WHERE id_cart=$userId");
    if($userDetail > 0 ){
        $deleteUser = delete('cart',"id_cart= $userId");
        if($deleteUser){
            if( $deleteUser ){
                setFlashData("smg","Xóa thành công");
                setFlashData("smg_type","success");
            }else{
                setFlashData("smg","Lỗi hệ thống");
                setFlashData("smg_type","danger");
            }
        }
    }else{
        setFlashData('smg','Không có hàng hóa tồn tại');
        setFlashData('smg_type','danger');
    }
}else{
    setFlashData('msg','Liên kết không tồn tại');
    setFlashData('msg_type','danger');
}
redirect('?module=home&action=cart');



