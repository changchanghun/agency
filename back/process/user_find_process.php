<?php 
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id         = $_REQUEST['find_id'];
    $name       = $_REQUEST['find_name'];
    $mobile     = $_REQUEST['find_mobile'];
    $type       = $_REQUEST['type'];
    
    $ch_pw      = $_REQUEST['change_password'];
    $ch_pw_chk  = $_REQUEST['change_password_confirm'];

    if(empty($type) || !in_array($type,[1,2,3])){
        header('Location:http://chworld2.dothome.co.kr/agency/index.php');
        exit();
    }

    $user_sql = "SELECT 
                    * 
                FROM 
                    agency_memberTBL 
                WHERE 
                    name = '{$name}'
                AND
                    ph = '{$mobile}'
                ";

    $user_row = mysqli_fetch_array(mysqli_query($mysqli, $user_sql));

    switch($type){
        case "1":           // 아이디 찾기

            if( empty($name) || empty($mobile) ){
                $_SESSION["error"] = "값을 입력해주세요";
                header('Location:http://chworld2.dothome.co.kr/agency/user_find.php?type=1');
                exit();
            }else if(empty($user_row['id'])){
                $_SESSION["error"] = "존재하는 회원이 없습니다";
                header('Location:http://chworld2.dothome.co.kr/agency/user_find.php?type=1');
                exit();
            }

            // 보여질 페이지로 아이디값 세션으로 던져주기
            $_SESSION["find_id"] = $user_row['id'];
            header('Location:http://chworld2.dothome.co.kr/agency/find_data.php?type=1');
            exit();

        case "2":           // 비밀번호 찾기
            if(empty($id) || empty($name) || empty($mobile)){
                $_SESSION["error"] = "값을 입력해주세요";
                header('Location:http://chworld2.dothome.co.kr/agency/user_find.php?type=2');
                exit();
            }else if(empty($user_row['id'])){
                $_SESSION["error"] = "존재하는 회원이 없습니다";
                header('Location:http://chworld2.dothome.co.kr/agency/user_find.php?type=2');
                exit();
            }else if($user_row['id'] != $id){
                $_SESSION["error"] = "값이 일치하지 않습니다";
                header('Location:http://chworld2.dothome.co.kr/agency/user_find.php?type=2');
                exit();
            }

            $_SESSION["find_id"] = $user_row['id'];
            header('Location:http://chworld2.dothome.co.kr/agency/find_data.php?type=2');
            exit();
        case "3":
            if(empty($ch_pw) || empty($ch_pw_chk)){
                $_SESSION["error"] = "값을 입력해주세요";
                header('Location:http://chworld2.dothome.co.kr/agency/user_find.php?type=3');
                exit();
            }else if($ch_pw != $ch_pw_chk){
                $_SESSION["error"] = "값이 일치하지 않습니다";
                header('Location:http://chworld2.dothome.co.kr/agency/user_find.php?type=2');
                exit();
            }

            $hash_pw = password_hash($ch_pw, PASSWORD_DEFAULT);

            $upd_sql = "UPDATE
                            agency_memberTBL
                        SET
                            pw = '{$hash_pw}'
                        WHERE
                            id = '{$_SESSION['find_id']}'
                        ";
            
            $upd_query = mysqli_query($mysqli, $upd_sql);

            unset($_SESSION['find_id']);
            if(!$upd_query){
                echo "<script>
                    alert('관리자에게 문의해주세요');
                    window.location.href = 'http://chworld2.dothome.co.kr/agency/index.php';
                    </script>";
                exit();
            }

            echo "<script>
                    alert('비밀번호가 변경되었습니다.');
                    window.location.href = 'http://chworld2.dothome.co.kr/agency/index.php';
                    </script>";
            exit();
    }

    exit();