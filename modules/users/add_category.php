<?php 
    $data = [
        'pageTitle' => 'Thêm thể loại',
    ];

    if(isPost()){
        $filterAll = filter();
        $errors = [];
        if(empty($filterAll['nameCategory'])){
            $errors['nameCategory']['required'] = 'Sản phẩm bắt buộc phải nhập';
    }else{
        if(strlen($filterAll['nameCategory']) < 2){
          $errors['nameCategory']['min'] = 'Sản phẩm bắt buộc có trên 1 kí tự';
  
    }}
    $a = $filterAll['nameCategory'];
    $category = oneRaw("SELECT * FROM add_category WHERE category = '$a'");
    if(!empty($category['category'])){
        $errors['nameCategory']['unique'] = 'Sản phẩm đã tồn tại';
    }

    
    if(empty($errors)){
        $dataInsert =[
            'category' => $filterAll['nameCategory'],
        ];
        $insertStatus= insert('add_category',$dataInsert);
        if($insertStatus){
            setFlashData('smg','Thêm thể loại thành công');
            setFlashData('smg_type','success');
        }else{
            setFlashData('smg','Thêm thể loại thất bại');
            setFlashData('smg_type','danger');
        }


        redirect('?module=users&action=list_product');
    }else{
        setFlashData('smg','vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type','danger');
        setFlashData('errors',$errors);
        setFlashData('old',$filterAll);
        redirect('?module=users&action=add_category');
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
        <h2 class = "text-center text-uppercase">Thêm thể loại </h2>
        <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
        ?>
        <form action ="" method ="post">
                <div class="row">
                    <div class="from-group mg-form">
                        <label for="">Tên thể loại</label>
                            <input name="nameCategory" type = "fullname" class="form-control" placeholder = "Tên thể loại" value="<?php 
                            echo (!empty($old['nameCategory'])) ? $old['nameCategory'] : null;
                            ?>">
                            <span class="error">
                            <?php 
                                if(!empty($errors['nameCategory'])){
                                    $errors_name = implode(' ',$errors['nameCategory']);
                                    echo $errors_name;
                            }
                        
                        ?></span>
                    </div>

                    <button type="submit" class ="mg-btn users btn btn-primary btn-block">Thêm sản phẩm</button>
                    <a href="?module=users&action=list_product" type="submit" class ="mg-btn users btn btn-success btn-block">Quay lại</a>
                </div>
        </form>
    </div> 
</div>
