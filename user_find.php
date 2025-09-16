<?php
    include_once('./back/public/dbConn.php');
    include_once('./public/unLogin_public.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아아디/비밀번호찾기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="img_wrap" style="width:50%; max-width:300px; margin: 0 auto;">
            <img src="./img/PF_LOGO2.png" style="width:100%; margin:100px 0;">
        </div>
        <div class="register-container">
            <h2 class="text-center mb-4 title"></h2>
            <form id="user_find_form" action="./back/process/user_find_process.php" method="post">
                <div class="mb-3 id_box">
                    <label for="find_id" class="form-label">아이디</label>
                    <input type="text" class="form-control" id="find_id" name="find_id" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" placeholder='영문 대소문자와 숫자만 사용할 수 있습니다' minlength="4" maxlength="20" required>
                </div>
                <?php if(isset($_SESSION['error1'])){
                    echo "<p style='color:red'>". $_SESSION["error1"] . "</p>";
                    unset($_SESSION['error1']);}
                ?>
                <?php if(isset($_SESSION['error4'])){
                    echo "<p style='color:red'>". $_SESSION["error4"] . "</p>";
                    unset($_SESSION['error4']);}
                ?>
                <div class="mb-3">
                    <label for="find_name" class="form-label">이름</label>
                    <input type="text" class="form-control" id="find_name" name="find_name" oninput="this.value = this.value.replace(/[0-9`~!@#$%^&*()_\-+=\[\]{}|\\;:'\,.<>/?]/g, '')" placeholder='이름은 한글 또는 영어만 입력 가능합니다' required>
                </div>
                <div class="mb-3">
                    <label for="find_mobile" class="form-label">전화번호</label>
                    <input type="tel" class="form-control" id="find_mobile" name="find_mobile" oninput="this.value = this.value.replace(^01[0-9]{8,9}$g, '')" placeholder='-을 제거한 숫자를 입력해주세요' required>
                </div>
                <?php if(isset($_SESSION['error'])){
                    echo "<p style='color:red'>". $_SESSION["error"] . "</p>";
                    unset($_SESSION['error']);}
                ?>
                <?php if(isset($_SESSION['error3'])){
                    echo "<p style='color:red'>". $_SESSION["error3"] . "</p>";
                    unset($_SESSION['error3']);}
                ?>
                <?php if(isset($_SESSION['error5'])){
                    echo "<p style='color:red'>". $_SESSION["error5"] . "</p>";
                    unset($_SESSION['error5']);}
                ?>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"></button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="index.php">로그인 페이지로 돌아가기</a>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script>
    let type = '<?= $_REQUEST['type'] ?>';
    let old_data = <?= json_encode($_SESSION['old_data'], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
    
    if(old_data){
        $('#find_id').val(old_data.old_id || '');
        $('#find_email').val(old_data.old_email || '');
        $('#find_mobile').val(old_data.old_mobile || '');
        $('#find_name').val(old_data.old_name || '');
    };

    // 아이디찾기
    if(type == "1"){
        $('.title').text('아이디 찾기');
        $('.btn').text('아이디 찾기');
        $('.id_box').hide();
        $('#find_id').val('dump_val');
        $('#user_find_form').attr('action', './back/process/user_find_process.php?type=1');
    }else if(type == "2"){
        $('.title').text('비밀번호 찾기');
        $('.btn').text('비밀번호 찾기');
        $('#user_find_form').attr('action', './back/process/user_find_process.php?type=2');
    }
</script>