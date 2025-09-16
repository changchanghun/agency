<?php 
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id         = $_REQUEST['regist_id'];
    $pw         = $_REQUEST['regist_password'];
    $pw_co      = $_REQUEST['regist_password_confirm'];
    $name       = $_REQUEST['regist_name'];
    $email      = $_REQUEST['regist_email'];
    $mobile     = $_REQUEST['regist_mobile'];

    $_SESSION['old_data'] = array(
        'old_id'        => $id,
        'old_name'      => $name,
        'old_email'     => $email,
        'old_mobile'    => $mobile
    );

    $user_sql = "SELECT * FROM agency_memberTBL WHERE id = '{$id}'";
    $user_query = mysqli_query($mysqli, $user_sql);
    $user_row = mysqli_fetch_array($user_query);

    $mobile_sql = "SELECT * FROM agency_memberTBL WHERE ph = '{$mobile}'";
    $mobile_query = mysqli_query($mysqli, $mobile_sql);
    $mobile_row = mysqli_fetch_array($mobile_query);

    if(strlen($id) < 4){
        // error1 : 아이디 4자리이하일때 막기 
        $_SESSION["error1"] = "4자리 이상 입력해주세요";
        header('Location:http://chworld2.dothome.co.kr/agency/register.php');
        exit();
    }else if($pw != $pw_co){
        // error2 : 비밀번호가 일치하지않을때 
        $_SESSION["error2"] = "비밀번호가 일치하지않습니다";
        header('Location:http://chworld2.dothome.co.kr/agency/register.php');
        exit();
    }else if(!preg_match('/^010\d{7,8}$/',$mobile)){
        // error3 : 전화번호 형식이 올바르지않을때 
        $_SESSION["error3"] = "전화번호 형식을 지켜주세요";
        header('Location:http://chworld2.dothome.co.kr/agency/register.php');
        exit();
    }else if(!empty($user_row['id'])){
        // 중복체크
        $_SESSION["error4"] = "이미 사용중인 아이디입니다";
        header('Location:http://chworld2.dothome.co.kr/agency/register.php');
        exit();
    }else if(!empty($mobile_row['ph'])){
        $_SESSION["error5"] = "이미 사용중인 전화번호입니다";
        header('Location:http://chworld2.dothome.co.kr/agency/register.php');
        exit();
    }

    // 비밀번호 해싱
    $hash_pw = password_hash($pw, PASSWORD_DEFAULT);

    $ins_user_sql = "INSERT INTO 
                            agency_memberTBL 
                            (id, pw, email, name, ph) 
                        VALUES 
                            ('{$id}','{$hash_pw}','{$email}','{$name}','{$mobile}')
                        ";
    $ins_user_query = mysqli_query($mysqli, $ins_user_sql);

    if(!$ins_user_query){
        echo "<script>
            alert('실패 : 관리자에게 문의해주세요');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/main.php';
            </script>";
        exit();
    }

    unset($_SESSION['old_data']);
    $_SESSION['user_id'] = $id;
    echo "<script>
            alert('정상적으로 가입되었습니다.');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/main.php';
            </script>";
    exit();