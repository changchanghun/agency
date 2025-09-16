<?php
    session_start();
    if($_SESSION['user_id']){
        header('Location:http://chworld2.dothome.co.kr/agency/main.php');
    }
?>
<!DOCTYPE html>
<html lang="ko">