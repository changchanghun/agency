<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $user_id = $_SESSION['user_id'];

    $sns_check_sql = "SELECT 
                        * 
                    FROM 
                        agency_SNS_loginTBL
                    WHERE 
                        user_uniq_id = {$user_id}
                    AND
                        type = 'kakao' 
                    ";

    $sns_result = mysqli_query($mysqli, $sns_check_sql);
    $sns_user = mysqli_fetch_array($sns_result);

    if($sns_user){
        $logout_url = "https://kapi.kakao.com/v1/user/logout";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $logout_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $_SESSION['kakao_access_token']
        ));
            
        curl_exec($ch);
        curl_close($ch);
            
        // 세션에서 카카오 토큰 제거
        unset($_SESSION['kakao_access_token']);
    }

    unset($_SESSION["user_id"]);

    // 로그인 페이지로 리다이렉트
    header("Location: http://chworld2.dothome.co.kr/agency");
    exit();
?> 