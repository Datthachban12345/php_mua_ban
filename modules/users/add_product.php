<?php 
$data = [
    'pageTitle' => 'Thêm sản phẩm',
];
$category = getRaw("SELECT * FROM add_category");
if(isPost()){
    $filterAll = filter();
    $errors = [];
        $hinhanhpath = basename($_FILES['img']['name']);
        $target_dir = "templates/image/";   
        $target_file = $target_dir.$hinhanhpath;
        if( move_uploaded_file($_FILES["img"]["tmp_name"],$target_file)){
            echo 'hình đã upload';
        }else{
            echo 'không lưu được';
        }
    if(empty($filterAll['nameProduct'])){
        $errors['nameProduct']['required'] = 'Sản phẩm bắt buộc phải nhập';
    }else{
        if(strlen($filterAll['nameProduct']) < 5){
        $errors['nameProduct']['min'] = 'Sản phẩm bắt buộc có 5 kí tự';
    }}

    // img

    // phàn giá cả
    if(empty($filterAll['price'])){
        $errors['price']['required'] = 'Giá gốc bắt buộc phải nhập';
    }
    if(strpos($filterAll['price'],'.')  == false){
        $strPrice = (string)$filterAll['price'];
        $c = 1;
        if(strpos($strPrice,'.')  == false){
            $price = "";
            
            for($count=(strlen($strPrice)-1);$count >= 0;$count--){
                $price = $price.$strPrice[$count];
                if($c ==3 and $count !=0){
                    $c = 0;
                    $price = $price.'.';
                }
                $c++;
            }
        }
        $price = strrev($price);
    }
    if(!empty($filterAll['priceNew'])){
        $strPriceNew = (string)$filterAll['priceNew'];
        $c = 1;
        if(strpos($strPriceNew,'.')  == false){
            $priceNew = "";
            
            for($count=(strlen($strPriceNew)-1);$count >= 0;$count--){
                $priceNew = $priceNew.$strPriceNew[$count];
                if($c ==3 and $count !=0){
                    $c = 0;
                    $priceNew = $priceNew.'.';
                }
                $c++;
            }
        }
        $priceNew = strrev($priceNew);
    }
    // giới thiệu
    if(empty($filterAll['describes'])){
        $errors['describes']['required'] = 'Thông tin sản phẩm bắt buộc phải nhập';
    }else{
    if(strlen($filterAll['describes']) < 5 ){
        $errors['describes']['min'] = 'Thông tin sản phẩm phải lớn hơn hoặc bằng 5';
    }

    }
    // thể loại

    if(empty($filterAll['category'])){  
        $errors['category']['required'] = 'thể loại bắt buộc phải chọn';
    }else{
    if($filterAll['category'] == "0"){
        $errors['category']['required'] = 'thể loại bắt buộc phải chọn';
    }
    }
    if(empty($errors)){  

        if(empty($filterAll['priceNew'])){
            $dataInsert =[
                'img' => $hinhanhpath,
                'nameProduct' => $filterAll['nameProduct'],
                'price' => $price,
                'describes' => $filterAll['describes'],
                'category' => $filterAll['category'],
            ];
        }
        $dataInsert =[
            'img' => $hinhanhpath,
            'nameProduct' => $filterAll['nameProduct'],
            'price' => $price,
            'priceNew'=> $priceNew,
            'describes' => $filterAll['describes'],
            'category' => $filterAll['category'],
        ];
        $insertStatus= insert('product',$dataInsert);
        if($insertStatus){
            setFlashData('smg','Thêm sản phẩm thành công');
            setFlashData('smg_type','success');
        }else{
            setFlashData('smg','Thêm sản phẩm thất bại');
            setFlashData('smg_type','danger');
        }


        redirect('?module=users&action=list_product');
    }else{
        setFlashData('smg','vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type','danger');
        setFlashData('errors',$errors);
        setFlashData('old',$filterAll);
        redirect('?module=users&action=add_product');
    }
}
$errors = getFlashData('errors');
$old = getFlashData('old');

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
layouts('header-login',$data);
?>
<div class="container">
    <h2 class = "text-center text-uppercase">Thêm người dùng </h2>
    <form action ="" method ="post" enctype="multipart/form-data">
        <div class="row">
        <?php 
            if(!empty ($smg)){
                getSmg($smg,$smg_type);
            }
        ?>
            <div class="col">
                <div class="from-group mg-form">
                    <label for="">Tên sản phẩm</label>
                        <input name="nameProduct" type = "fullname" class="form-control" placeholder = "Tên sản phẩm" value="<?php 
                        echo (!empty($old['nameProduct'])) ? $old['nameProduct'] : null;
                        ?>">
                        <span class="error">
                        <?php 
                            if(!empty($errors['nameProduct'])){
                                $errors_name = implode(' ',$errors['nameProduct']);
                                echo $errors_name;
                        }
                    
                    ?></span>
                </div>
                <div class="mb-3 from-group mg-form">
                    <label for="formFile"  class="form-label">Gửi ảnh vào đây</label>
                    <input class="form-control" name= "img" type="file" id="formFile" value="<?php 
                    echo (!empty($old['img'])) ? $old['img'] : null;
                    ?>">
                    <span class="error">
                        <?php 
                            if(!empty($errors['img'])){
                                $errors_img = implode(' ',$errors['img']);
                                echo $errors_img;
                        }
                    
                    ?></span>
                </div>

                
                <div class="from-group mg-form">
                    <label for="">Nhập giá gốc</label>
                    <input name="price" type = "number" class="form-control" placeholder = "Nhập giá" value="<?php 
                    echo (!empty($old['price'])) ? $old['price'] : null;
                    ?>">
                    <span class="error">
                        <?php 
                            if(!empty($errors['price'])){
                                $errors_price = implode(' ',$errors['price']);
                                echo $errors_price;
                            }
                    ?></span>
                </div>
                <div class="from-group mg-form">
                    <label for="">Nhập giá khi giảm giá(Nếu có)</label>
                    <input name="priceNew" type = "number" class="form-control" placeholder = "Nhập giá khi giảm giá" value="<?php 
                    echo (!empty($old['priceNew'])) ? $old['priceNew'] : null;
                    ?>">
                </div>

                <div class="from-group mg-form">
                        <label for="">Giới thiệu sản phẩm</label>
                        <textarea name = "describes" id="editor" class="form-control" value="<?php 
                        echo (!empty($old['describes'])) ? $old['describes'] : null;
                    ?>"></textarea>
                </div>
                <div class="from-group mg-form">
                    <label for="">Thể loại sản phẩm</label>
                    <select class="form-select" name="category" aria-label="Default select example">
                        <option>Chọn thể loại</option>
                        <?Php 
                        if(empty($category)):
                        ?>
                        <option value="Sách">Sách</option>
                        <option value="Phim">Phim</option>
                        <option value="Game">Game</option>
                        <?php 
                        endif;
                        if(!empty($category)):
                            foreach($category as $item):
                        ?>
                            <option value="<?php echo $item['category']; ?>"><?php echo $item['category']; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                        </select>
                        <span class="error">
                            <?php 
                                if(!empty($errors['category'])){
                                    $errors_category = implode(' ',$errors['category']);
                                    echo $errors_category;
                                }
                    
                            ?></span>   
                </div>

            </div>
        </div>
        <br><button type="submit" class ="mg-btn users btn btn-primary btn-block">Submit</button>
        <a href="?module=users&action=list_product" type="submit" class ="mg-btn users btn btn-success btn-block">Quay lại</a>
        </form>
    </div>


    
<script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
<?php 
layouts('footer-login');
?>