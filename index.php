<?php
    include_once('./back/public/dbConn.php');
    include_once('./public/unLogin_public.php');
    include_once('./popup_pack.php');
    session_unset();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="../agency/css/index.css">
</head>
    <div class="container">
        <div class="img_wrap">
            <img src="./img/PF_LOGO2.png">
        </div>
        <div class="login-container">
            <h2>로그인</h2>
            <form action="./back/process/login_process.php" method="POST">
                <div id="I_id">
                    <label for="id" class="form-label">아이디</label>
                    <input type="id" class="form-control" id="id" name="id" required>
                </div>
                <div id="I_pw">
                    <label for="password" class="form-label">비밀번호</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div id="login_btn">
                    <button type="submit" class="btn">로그인</button>
                </div>
            </form>
            
            <div class="mid_box">
                <a href="register.php">회원가입</a> |
                <a href="user_find.php?type=1">아이디 찾기</a> |
                <a href="user_find.php?type=2">비밀번호 찾기</a>
            </div>

            <div class="sns-login">
                <h5>SNS 로그인</h5>
                <button class="sns-btn naver-btn" onclick="location.href='./back/login/naver_login.php'">네이버 로그인</button>
                <button class="sns-btn kakao-btn" onclick="location.href='./back/login/kakao_login.php'">카카오 로그인</button>
            </div>
        </div>
    </div>
<script>
    function checkInputs() {
        const id = $('#id').val().trim();
        const pw = $('#password').val().trim();

        if (id !== '' && pw !== '') {
            $('.btn').addClass('active');
        } else {
            $('.btn').removeClass('active');
        }
    }

    $('#id, #password').on('input', checkInputs);
</script>