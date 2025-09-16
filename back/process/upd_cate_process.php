<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id         = $_SESSION['user_id'];
    $cate       = $_REQUEST['cate'];

    if( empty($cate) ){
        echo "false1";
        exit();
    }
    
    $mem_sql = "SELECT * FROM agency_memberTBL WHERE id = '{$id}' AND status = 'Y'";
    $mem_row = mysqli_fetch_array(mysqli_query($mysqli, $mem_sql));
    
    if(empty($mem_row['id'])){
        echo "error";
        exit();
    }

    $cate_arr = [];             // A
    foreach($cate as $item){
        $cate_arr[] = $item;
    }

    $use_cate_sql = "SELECT * FROM agency_mem_useTBL WHERE id = '{$id}' AND status = 'Y'";
    $use_cate_query = mysqli_query($mysqli, $use_cate_sql);

    $cate_use_arr = [];         // B
    while($use_cate_row = mysqli_fetch_array($use_cate_query)){
        $cate_use_arr[] = $use_cate_row['cate'];
    }

    $res_cate_arr = array_diff($cate_arr, $cate_use_arr);       // A가 기준
    $res_cate_use_arr = array_diff($cate_use_arr, $cate_arr);   // B가 기준

    if(count($res_cate_arr) > 0){
        $ins_arr = [];
        foreach($res_cate_arr as $item){
            $check_sql = "SELECT * FROM agency_mem_useTBL WHERE id = '{$id}' AND cate = '{$item}' AND status = 'N'";
            $check_row = mysqli_fetch_array(mysqli_query($mysqli, $check_sql));

            if($check_row){
                $upd_cate_sql = "UPDATE agency_mem_useTBL SET status = 'Y' WHERE id = '{$id}' AND cate = '{$item}'";
                mysqli_query($mysqli, $upd_cate_sql);
            }else{
                $ins_cate_sql = "INSERT INTO agency_mem_useTBL (id,cate) VALUES ('{$id}','{$item}')";
                mysqli_query($mysqli, $ins_cate_sql);
            }
        }
    }

    if(count($res_cate_use_arr) > 0){
        foreach($res_cate_use_arr as $item){
            $upd_cate_sql = "UPDATE agency_mem_useTBL SET status = 'N' WHERE id = '{$id}' AND cate = '{$item}'";
            $upd_cate_query = mysqli_query($mysqli, $upd_cate_sql);
            if(!$upd_cate_query){echo "error1"; exit();};
        }
    }

    echo "true";
    exit();
