<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id         = $_REQUEST["id"];
    $pw         = $_REQUEST["password"];

    $user_chk_sql = "SELECT 
                        * 
                    FROM 
                        agency_memberTBL 
                    WHERE
                        id = '{$id}'
                    limit 1
                ";

    $user_chk_row = mysqli_fetch_array(mysqli_query($mysqli, $user_chk_sql));

    if(!$user_chk_row["id"] || $user_chk_row["id"] == ""){
        echo "<script>
            alert('존재하지않는 회원입니다');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/index.php';
            </script>";
        exit();
    }else if(!password_verify($pw, $user_chk_row['pw'])){
        echo "<script>
            alert('아이디 또는 비밀번호를 확인해주세요');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/index.php';
            </script>";
        exit();
    }

    $_SESSION["user_id"] = $id;
    header("Location:http://chworld2.dothome.co.kr/agency/main.php");
    exit();

?>


    