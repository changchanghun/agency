<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id         = $_SESSION['user_id'];
    $agency     = trim($_REQUEST['agency']);
    $age        = trim($_REQUEST['age']);
    $level      = trim($_REQUEST['level']);
    $cate       = $_REQUEST['cate'];

    $ag_table = [];
    if(empty($agency) || empty($level) || empty($cate) || empty($age)){
        echo "false1";
        exit();
    }else if(!in_array($agency,['LG','SK','KT'])){
        echo "false2";
        exit();
    }

    $mem_sql = "SELECT * FROM agency_memberTBL WHERE id = '{$id}' AND status = 'Y'";
    $mem_row = mysqli_fetch_array(mysqli_query($mysqli, $mem_sql));
    
    if(empty($mem_row['id'])){
        echo "error";
        exit();
    }

    $ag_chk_sql = "SELECT
                        level
                    FROM
                        agency_typeTBL
                    GROUP BY
                        level
                    ";
    
    $ag_chk_query = mysqli_query($mysqli, $ag_chk_sql);
    
    while($ag_data = mysqli_fetch_array($ag_chk_query)){
        $ag_table[] = $ag_data['level'];
    };

    if(!in_array($level,$ag_table)){
        echo "false3";
        exit();
    }

    $upd_user_sql = "UPDATE 
                        agency_memberTBL
                    SET
                        way         = '{$agency}',
                        age         = '{$age}',
                        lev         = '{$level}',
                        fir_flag    = 'N'
                    WHERE
                        id = '{$_SESSION['user_id']}'
                    ";

    $upd_user_query = mysqli_query($mysqli, $upd_user_sql);

    if(!$upd_user_query){
        echo "error";
        exit();
    }

    $cate_arr = [];
    foreach($cate as $item){
        $cate_arr[] = "('{$_SESSION['user_id']}','{$item}')";
    }
    $cate_data = implode(',',$cate_arr);

    $upd_cate_sql = "INSERT INTO 
                            agency_mem_useTBL (id,cate) 
                        VALUES 
                            {$cate_data}
                        ";
        
    $upd_cate_query = mysqli_query($mysqli, $upd_cate_sql);

    if(!$upd_cate_query){
        echo "error";
        exit();
    }

    echo "true";
    exit();
