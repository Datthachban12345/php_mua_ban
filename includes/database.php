<?php
function query($sql, $data=[],$check = false){
    global $conn;
    $ketqua = false;
    try{
        $statement = $conn -> prepare($sql);
        if(!empty($data)){
            $ketqua = $statement -> execute($data);
            // execute
        }
        else{
            $ketqua = $statement -> execute();
        }
        
    }catch(Exception $exp){
        echo $exp -> getMessage().'<br>';
        echo 'File'.$exp -> getFile().'<br>';
        echo 'Line'.$exp -> getLine();
        die();
    }
    if($check){
        return $statement;
    }
    return $ketqua;
}
function insert($table,$data){
    $key = array_keys($data);
    $truong = implode(',',$key);
    $valuetb = ':'.implode(',:',$key);
    $sql = 'INSERT INTO '. $table . '('.$truong.')'.'VALUES('.$valuetb.')';
    $kq = query($sql, $data);
    return $kq;
}
function update($table,$data,$condition = ''){
    $update = '';
    foreach($data as $key => $value){
        $update .= $key .'= :'. $key .',';
    }   
    $update = trim($update,',');
    if(!empty($condition)){
        $sql = 'UPDATE '. $table. ' SET '.$update.' WHERE '.$condition;
    }else{
        $sql = 'UPDATE '. $table. ' SET '.$update;
    }
    $kq = query($sql, $data);
    return $kq;
}
function edit($table,$column,$data,$condition){
    $sql = 'UPDATE '.$table.' SET '.$column.' = CONCAT('.$column.', "'.$data.'") WHERE '.$condition;
    $kq = query($sql);
    return $kq;
}
function editDelete($table,$column,$data,$condition){
    $sql = 'UPDATE ' .$table.' SET '.$column.' = REPLACE('.$column.', "'.$data.'", "") WHERE '.$condition;
    $kq = query($sql);
    return $kq;
}

function delete($table,$condition = ''){
    if(empty($condition)){
        $sql = 'DELETE FROM ' .$table;
    }else {
        $sql = 'DELETE FROM '.$table .' WHERE '.$condition;
    }
    $kq = query($sql);
    return $kq;
}
// lấy nhiều dòng dữ liệu
function getRaw ($sql){
    $kq = query($sql,'',true);
    if(is_object($kq)){
        $dataFech = $kq -> fetchAll(PDO::FETCH_ASSOC);

    }
    return $dataFech;
}
// lấy 1 dòng
function oneRaw ($sql){
    $kq = query($sql,'',true);
    if(is_object($kq)){
        $dataFech = $kq -> fetch(PDO::FETCH_ASSOC);

    }
    return $dataFech;
}
// đếm số dòng dữ liệu
function getRows ($sql){
    $kq = query($sql,'',true);
    if(!empty($kq)){
        return $kq -> rowCount();

    }
    
}