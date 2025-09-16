<?php
session_start();
$env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/agency/.env');
$client_id = $env['KAKAO_API_KEY'];
$redirect_uri = urlencode("http://chworld2.dothome.co.kr/agency/back/login/kakao_callback.php");
$state = md5(uniqid(rand(), true));
$_SESSION['state'] = $state;

$kakao_auth_url = "https://kauth.kakao.com/oauth/authorize?client_id=" . $client_id
    . "&redirect_uri=" . $redirect_uri
    . "&response_type=code"
    . "&state=" . $state;

header('Location: ' . $kakao_auth_url);
?> 