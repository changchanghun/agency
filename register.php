<?php
    include_once('./back/public/dbConn.php');
    include_once('./public/unLogin_public.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }

        .img_wrap{
            width:50%; 
            max-width:300px; 
            margin: 0 auto;
        }
        .img_wrap img{
            width:100%; 
            margin:100px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="img_wrap">
            <img src="./img/PF_LOGO2.png">
        </div>
        <div class="register-container">
            <h2 class="text-center mb-4">회원가입</h2>
            <form action="./back/process/register_process.php" method="post">
                <div class="mb-3">
                    <label for="regist_id" class="form-label">아이디</label>
                    <input type="text" class="form-control" id="regist_id" name="regist_id" onkeydown="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" placeholder='영문 / 숫자만 사용할 수 있습니다' minlength="4" maxlength="20" required>
                </div>
                <?php if (isset($_SESSION['error1'])): ?>
                    <p style="color:red"><?= $_SESSION['error1'] ?></p>
                        <script>
                            $(document).ready(function () {
                                setTimeout(() => {
                                     $('html, body').animate({
                                        scrollTop: $('#regist_id').offset().top - 50
                                    }, 0);
                                    $('#regist_id').focus();
                                }, 300);
                            });
                        </script>
                        <?php unset($_SESSION['error1']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error4'])): ?>
                    <p style="color:red"><?= $_SESSION['error4'] ?></p>
                        <script>
                            $(document).ready(function () {
                                setTimeout(() => {
                                     $('html, body').animate({
                                        scrollTop: $('#regist_id').offset().top - 50
                                    }, 0);
                                    $('#regist_id').focus();
                                }, 300);
                            });
                        </script>
                        <?php unset($_SESSION['error4']); ?>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="regist_name" class="form-label">이름</label>
                    <input type="text" class="form-control" id="regist_name" name="regist_name" oninput="this.value = this.value.replace(/[0-9`~!@#$%^&*()_\-+=\[\]{}|\\;:'\,.<>/?]/g, '')" placeholder='이름은 한글 또는 영어만 입력 가능합니다' required>
                </div>
                <div class="mb-3">
                    <label for="regist_email" class="form-label">이메일</label>
                    <input type="email" class="form-control" id="regist_email" name="regist_email"  placeholder='@가 들어간 이메일 형식을 입력해주세요' required>
                </div>
                <div class="mb-3">
                    <label for="regist_mobile" class="form-label">전화번호</label>
                    <input type="tel" class="form-control" id="regist_mobile" name="regist_mobile" oninput="this.value = this.value.replace(^01[0-9]{8,9}$g, '')" placeholder='-을 제거한 숫자를 입력해주세요' required>
                </div>
                <?php if (isset($_SESSION['error3'])): ?>
                    <p style="color:red"><?= $_SESSION['error3'] ?></p>
                        <script>
                            $(document).ready(function () {
                                setTimeout(() => {
                                     $('html, body').animate({
                                        scrollTop: $('#regist_mobile').offset().top - 50
                                    }, 0);
                                    $('#regist_mobile').focus();
                                }, 300);
                            });
                        </script>
                        <?php unset($_SESSION['error3']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error5'])): ?>
                    <p style="color:red"><?= $_SESSION['error5'] ?></p>
                        <script>
                            $(document).ready(function () {
                                setTimeout(() => {
                                     $('html, body').animate({
                                        scrollTop: $('#regist_mobile').offset().top - 50
                                    }, 0);
                                    $('#regist_mobile').focus();
                                }, 300);
                            });
                        </script>
                        <?php unset($_SESSION['error5']); ?>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="regist_password" class="form-label">비밀번호</label>
                    <input type="password" class="form-control" id="regist_password" name="regist_password" required>
                </div>
                <?php if (isset($_SESSION['error2'])): ?>
                    <p style="color:red"><?= $_SESSION['error2'] ?></p>
                        <script>
                            $(document).ready(function () {
                                setTimeout(() => {
                                     $('html, body').animate({
                                        scrollTop: $('#regist_password').offset().top - 50
                                    }, 0);
                                    $('#regist_password').focus();
                                }, 300);
                            });
                        </script>
                        <?php unset($_SESSION['error2']); ?>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="regist_password_confirm" class="form-label">비밀번호 확인</label>
                    <input type="password" class="form-control" id="regist_password_confirm" name="regist_password_confirm" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">가입하기</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="index.php">로그인 페이지로 돌아가기</a>
            </div>
        </div>
    </div>
</body>

<script>
    let old_data = <?= json_encode($_SESSION['old_data'], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
    
    if(old_data){
        $('#regist_id').val(old_data.old_id || '');
        $('#regist_email').val(old_data.old_email || '');
        $('#regist_mobile').val(old_data.old_mobile || '');
        $('#regist_name').val(old_data.old_name || '');
    };

</script>