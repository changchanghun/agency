<?php 
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 
    $id = $_SESSION['user_id'];

    if(!$id || $id == ''){
        header("Location:http://chworld2.dothome.co.kr/agency/index.php");
        exit();
    };

    $user_chk_sql = "SELECT 
                        * 
                    FROM
                        agency_memberTBL 
                    WHERE
                        id = '{$id}'
                    AND
                        status = 'Y'
                    limit 1
                ";

    $user_chk_row = mysqli_fetch_array(mysqli_query($mysqli, $user_chk_sql));

    if(empty($user_chk_row['id'])){
        unset ($_SESSION['user_id']);
        header("Location:http://chworld2.dothome.co.kr/agency/index.php");
        exit();
    }