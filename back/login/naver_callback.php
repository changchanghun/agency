<?php
  session_start();
  include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 
  $env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/agency/.env');
  $client_id = $env['NAVER_CLIENT_ID'];
  $client_secret = $env['NAVER_CLIENT_SECRET'];
  $code = $_GET["code"];
  $state = $_GET["state"];
  $redirect_uri = urlencode("http://chworld2.dothome.co.kr/agency/back/login/naver_callback.php");
  $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
  $is_post = false;
  
  // 요청1
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, $is_post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $headers = array();
  $response = curl_exec ($ch);
  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close ($ch);

  if($status_code == 200) {
    $token = json_decode($response, true);
    
    // 요청2
    $access_token = $token['access_token'];
    $url = "https://openapi.naver.com/v1/nid/me";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $headers = ["Authorization: Bearer " . $access_token];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $user_data = json_decode($result, true);

    if($user_data['response']['id']){

        $check_sql = "SELECT 
                            * 
                        FROM 
                            agency_memberTBL
                        WHERE
                            type = 'naver'
                        AND 
                            id = '{$user_data['response']['id']}'
                    ";
        
        $check_row = mysqli_fetch_array(mysqli_query($mysqli, $check_sql));

        if(isset($check_row['id']) && $check_row['id'] != ''){
            $_SESSION['user_id'] = $check_row['id'];
            header("Location: http://chworld2.dothome.co.kr/agency/main.php");
        }

        $mobile = preg_replace("/[^0-9]/", "", $user_data['response']['mobile']);

        $ph_chk_sql = "SELECT * FROM agency_memberTBL WHERE ph = {$mobile} AND status = 'Y'";
        $ph_chk_row = mysqli_fetch_array(mysqli_query($mysqli,$ph_chk_sql));

        if($ph_chk_row['id']){
            echo "<script>
                alert('이미 사용중인 전화번호입니다.');
                window.location.href = 'http://chworld2.dothome.co.kr/agency/index.php';
                </script>";
            exit();
        }

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
                            '{$user_data['response']['id']}', 
                            '{$user_data['response']['email']}',
                            '{$user_data['response']['name']}',
                            $mobile,
                            'naver'
                        )";

        $ins_query = mysqli_query($mysqli, $ins_sql);

        if(!$ins_query){
            header("Location: index.php?error=sns_login_failed");
        };

        $_SESSION['user_id'] = $user_data['response']['id'];
        echo "<script>
            alert('가입이 완료되었습니다.');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/main.php';
            </script>";
        
    }else{
        header("Location: index.php?error=sns_login_failed");
    }

  } else {
    echo "Error 내용:".$response;
  }
