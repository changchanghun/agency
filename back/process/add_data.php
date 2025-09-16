<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/regData.php"); 

    $name   = trim($_REQUEST['name']);
    $phone  = trim($_REQUEST['phone']);

    if(empty($name) || empty($phone) ){
        echo "false1";
        exit();
    }else if(!preg_match($reg_name,$name)){
        echo "false2";
        exit();
    }else if(!preg_match($reg_mobile,$phone)){
        echo "false3";
        exit();
    }

    $user_chk_sql = "SELECT 
                        * 
                    FROM 
                        agency_memberTBL 
                    WHERE 
                        ph = '{$phone}' 
                    AND 
                        status = 'Y'
                    ";

    $user_chk_row = mysqli_fetch_array(mysqli_query($mysqli, $user_chk_sql));

    if($user_chk_row['id']){
        echo "false4";
        exit();
    }

    $upd_user_sql = "UPDATE 
                        agency_memberTBL
                    SET
                        name = '{$name}',
                        ph = '{$phone}'
                    WHERE
                        id = '{$_SESSION['user_id']}'
                    ";
    
    $upd_user_query = mysqli_query($mysqli, $upd_user_sql);

    if(!$upd_user_query){
        echo "error";
        exit();
    }

    echo "true";
    exit();
