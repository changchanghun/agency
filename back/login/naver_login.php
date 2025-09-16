<?php
session_start();
$env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/agency/.env');
$client_id = $env['NAVER_API_KEY'];
$redirect_uri = urlencode("http://chworld2.dothome.co.kr/agency/back/login/naver_callback.php");
$state = md5(uniqid(rand(), true));
$_SESSION['state'] = $state;

$naver_auth_url = "https://nid.naver.com/oauth2.0/authorize?response_type=code"
    . "&client_id=" . $client_id
    . "&redirect_uri=" . $redirect_uri
    . "&state=" . $state;
 
header('Location: ' . $naver_auth_url);
?> 