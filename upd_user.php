<?php
    include_once('./public/login_public.php');
    include_once('./popup_pack.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원정보수정</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .upd-container {
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
        <div class="upd-container">
            <h2 class="text-center mb-4">회원 정보 수정</h2>
            <form action="./back/process/upd_user_process.php" method="post">
                <div class="mb-3">
                    <label for="upd_name" class="form-label">이름</label>
                    <input type="text" class="form-control" id="upd_name" name="upd_name" oninput="this.value = this.value.replace(/[0-9`~!@#$%^&*()_\-+=\[\]{}|\\;:'\,.<>/?]/g, '')" placeholder='이름은 한글 또는 영어만 입력 가능합니다' required>
                </div>
                <div class="mb-3">
                    <label for="upd_email" class="form-label">이메일</label>
                    <input type="email" class="form-control" id="upd_email" name="upd_email" oninput="this.value = this.value.replace(/^[^\s@]+@[^\s@]+\.[^\s@]+$/g, '')" placeholder='@가 들어간 이메일 형식을 입력해주세요' required>
                </div>
                <div class="mb-3">
                    <label for="upd_mobile" class="form-label">전화번호</label>
                    <input type="tel" class="form-control" id="upd_mobile" name="upd_mobile" oninput="this.value = this.value.replace(^01[0-9]{8,9}$g, '')" placeholder='-을 제거한 숫자를 입력해주세요' required>
                </div>
                <?php if(isset($_SESSION['error1'])){
                    echo "<p style='color:red'>". $_SESSION["error1"] . "</p>";
                    unset($_SESSION['error1']);}
                ?>
                <?php if(isset($_SESSION['error2'])){
                    echo "<p style='color:red'>". $_SESSION["error2"] . "</p>";
                    unset($_SESSION['error2']);}
                ?>
                <?php if(isset($_SESSION['error3'])){
                    echo "<p style='color:red'>". $_SESSION["error3"] . "</p>";
                    unset($_SESSION['error3']);}
                ?>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">수정하기</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="main.php">메인 페이지로 돌아가기</a>
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script>
    let rawJson = '<?= $DATA_JSON ?>';
    let cleanJson = rawJson.replace(/[\u0000-\u001F]+/g, "");
    let common_data = JSON.parse(cleanJson);
    
    $('#upd_name').val(common_data.user_data.name);
    $('#upd_mobile').val(common_data.user_data.ph);
    $('#upd_email').val(common_data.user_data.email)

</script>