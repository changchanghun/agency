<?php 
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id         = $_SESSION['user_id'];
    $name       = trim($_REQUEST['upd_name']);
    $email      = trim($_REQUEST['upd_email']);
    $mobile     = trim($_REQUEST['upd_mobile']);

    if( empty($name) || empty($email) || empty($mobile)){
        // error1 : 빈값 허용 x 
        $_SESSION["error1"] = "정보를 입력해주세요";
        header('Location:http://chworld2.dothome.co.kr/agency/upd_user.php');
        exit();
    }

    $user_sql = "SELECT * FROM agency_memberTBL WHERE id = '{$id}'";
    $user_query = mysqli_query($mysqli, $user_sql);
    $user_row = mysqli_fetch_array($user_query);

    $mobile_sql = "SELECT * FROM agency_memberTBL WHERE ph = '{$mobile}'";
    $mobile_query = mysqli_query($mysqli, $mobile_sql);
    $mobile_row = mysqli_fetch_array($mobile_query);

    if($user_row['name'] == $name && $user_row['email'] == $email && $user_row['ph'] == $mobile){
        // true : 저장정보와 동일한값 제출시
        header('Location:http://chworld2.dothome.co.kr/agency/main.php');
        exit();
    }else if(!preg_match('/^010\d{7,8}$/',$mobile)){
        // error2 : 전화번호 형식이 올바르지않을때 
        $_SESSION["error2"] = "전화번호 형식을 지켜주세요";
        header('Location:http://chworld2.dothome.co.kr/agency/upd_user.php');
        exit();
    }else if(!empty($mobile_row['ph']) && $mobile_row['id'] != $id){
        $_SESSION["error3"] = "이미 사용중인 전화번호입니다";
        header('Location:http://chworld2.dothome.co.kr/agency/register.php');
        exit();
    }

    $upd_sql = "UPDATE 
                    agency_memberTBL 
                SET 
                    name = '{$name}',
                    email = '{$email}',
                    ph = '{$mobile}'
                WHERE
                    id = '{$id}'
                ";
    
    $upd_query = mysqli_query($mysqli, $upd_sql);

    if(!$upd_query){
         echo "<script>
            alert('실패 : 관리자에게 문의해주세요');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/main.php';
            </script>";
        exit();
    }

    header('Location:http://chworld2.dothome.co.kr/agency/main.php');
    exit();