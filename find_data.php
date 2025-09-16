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
        .user_find_container {
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
        <div class="user_find_container">
            <h2 class="text-center mb-4 title"></h2>
            <div class="tab1">
                <p>아이디 결과 : <span class="res_id"></span></p>
            </div>
            <div class="tab2">
                <form id="user_find_form" action="./back/process/user_find_process.php?type=3" method="post">
                    <div class="mb-3">
                        <label for="change_password" class="form-label">변경 비밀번호</label>
                        <input type="password" class="form-control" id="change_password" name="change_password" required>
                    </div>
                    <?php if(isset($_SESSION['error'])){
                        echo "<p style='color:red'>". $_SESSION["error"] . "</p>";
                        unset($_SESSION['error']);}
                    ?>
                    <div class="mb-3">
                        <label for="change_password_confirm" class="form-label">변경 비밀번호 확인</label>
                        <input type="password" class="form-control" id="change_password_confirm" name="change_password_confirm" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
            <div class="text-center mt-3">
                <a href="index.php">로그인 페이지로 돌아가기</a>
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script>
    type = '<?= $_REQUEST['type'] ?>';
    find_id = '<?= $_SESSION['find_id'] ?>';

    // 아이디찾기
    if(type == "1"){
        $('.title').text('아이디 찾기');
        $('.res_id').text(find_id);
        $('.tab2').css('display','none');
        $('.tab1').css('display','block');
    }else if(type == "2"){
        $('.title').text('비밀번호 찾기');
        $('.btn').text('비밀번호 변경');
        $('.tab1').css('display','none');
        $('.tab2').css('display','block');
    }
</script>