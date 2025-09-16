<?php
    session_start();
    $env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/agency/.env');
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 
    $client_id = $env['KAKAO_CLIENT_ID'];
    $client_secret = $env['KAKAO_CLIENT_SECRET'];
    $redirect_uri = urlencode("http://chworld2.dothome.co.kr/agency/back/login/kakao_callback.php");
    $code = $_GET['code'];
    $state = $_GET['state'];

    if ($state !== $_SESSION['state']) {
        echo "잘못된 접근입니다.";
        exit;
    }

    // 토큰 받기
    $token_url = "https://kauth.kakao.com/oauth/token";
    $post_data = array(
        'grant_type' => 'authorization_code',
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => urldecode($redirect_uri),
        'code' => $code
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    $response = curl_exec($ch);
    curl_close($ch);

    $token = json_decode($response, true);

    if (isset($token['access_token'])) {
        // 사용자 정보 가져오기
        $profile_url = "https://kapi.kakao.com/v2/user/me";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $profile_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token['access_token']
        ));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $user_info = json_decode($response, true);

        if ($user_info['id']) {
            $kakao_id = $user_info['id'];
            $email = isset($user_info['kakao_account']['email']) ? $user_info['kakao_account']['email'] : '';
            $nickname = isset($user_info['properties']['nickname']) ? $user_info['properties']['nickname'] : '-';

            // 액세스 토큰을 세션에 저장 (로그아웃 시 사용)
            $_SESSION['kakao_access_token'] = $token['access_token'];

            // SNS 사용자 확인
            $sns_check_sql = "SELECT 
                                    * 
                                FROM 
                                    agency_memberTBL 
                                WHERE 
                                    type = 'kakao' 
                                AND 
                                    id = '{$kakao_id}' 
                                ";

            $sns_check_result = mysqli_query($mysqli, $sns_check_sql);
            $user_data = mysqli_fetch_array($sns_check_result);

            if ($user_data) {
                // 기존 사용자 로그인
                $_SESSION['user_id'] = $user_data['id'];
                header("Location: http://chworld2.dothome.co.kr/agency/main.php");
            } else {
                $ins_sql = "INSERT INTO 
                                agency_memberTBL
                                (
                                    id, 
                                    email,
                                    name,
                                    ph,
                                    type
                                ) 
                            VALUES 
                                (
                                    '{$kakao_id}', 
                                    '{$email}',
                                    '{$nickname}',
                                    '0000',
                                    'kakao'
                                )";

                $ins_query = mysqli_query($mysqli, $ins_sql);

                if(!$ins_query){
                    header("Location: index.php?error=sns_login_failed");
                };
                $_SESSION['user_id'] = $kakao_id;
                header("Location: http://chworld2.dothome.co.kr/agency/main.php");
            }
        }
    } else {
        header("Location: index.php?error=sns_login_failed");
    }
?> 