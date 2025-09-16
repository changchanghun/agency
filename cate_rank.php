<?php
    include_once('./public/login_public.php');
    include_once('./popup_pack.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>대시보드</title>
    <link rel="stylesheet" href="../agency/css/cate_rank.css">
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=289d13144fdda88c0ecd81e7c27fc0df&libraries=services&autoload=false"></script>
</head>
<body>
    <!-- 햄버거 버튼 -->
    <button class="hamburger-btn" id="hamburgerBtn">☰</button>
    
    <!-- 사이드 메뉴 -->
    <div class="side-menu" id="sideMenu">
        <a href="upd_user.php" class="menu-item">
            <i>👤</i>회원정보수정
        </a>
        <a href="upd_cate.php" class="menu-item">
            <i>⚙️</i>카테고리설정
        </a>
        <a href="cate_rank.php" class="menu-item">
            <i>&#127894;</i>추천 카테고리
        </a>
        <div class="menu-item" onclick="showConfirmModal('회원탈퇴','정말 탈퇴하시겠습니까?',()=>{window.location.href = './back/process/del_user.php';})">
            <i>&#128682;</i>회원탈퇴
        </div>
    </div>
    
    <!-- 오버레이 -->
    <div class="side-menu-overlay" id="sideMenuOverlay"></div>

    <div class="container">
        <div class="dashboard-container">
            <h2>현재 <span class="agency"></span>통신사의 <span class="age"></span> 인기 카테고리입니다.</h2>
            <div class="rank_div">
                <div class="rank_wrap rank1">
                    <h2>1위</h2>
                    <div class="rank_body"></div>
                </div>
                <div class="rank_wrap rank2">
                    <h2>2위</h2>
                    <div class="rank_body"></div>
                </div>
                <div class="rank_wrap rank3">
                    <h2>3위</h2>
                    <div class="rank_body"></div>
                </div>
            </div>   
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
    let my_agency = common_data.user_data.way;
    let my_age = common_data.user_data.age;

    // $.each(common_data.age_rank[my_agency][my_age], function(key, val)){
    //     $('.temp_div').append(val);
    // };

    let temp_age = '';
    switch(my_age){
        case "1" : 
            temp_age = "10대";
            break;
        case "2" :
            temp_age = "20대";
            break;
        case "3" :
            temp_age = "30대";
            break;
        case "4" :
            temp_age = "40대";
            break;
        case "5" :
            temp_age = "50대";
            break;
    }
    $('.agency').text(my_agency);
    $('.age').text(temp_age);
    const ranks = Object.values(common_data.age_rank[my_agency][my_age]);

    ranks.forEach((item) => {
        item.cate.forEach((cateName) => {
            const $target = $(`.rank${item.rank} .rank_body`);
            $target.append(`<div class="cate_div">${cateName}</div>`);
        });
    });

    [1, 2, 3].forEach(rank => {
        const $body = $(`.rank${rank} .rank_body`);
        if ($body.find(".cate_div").length === 0) {
            $body.append(`<div class="empty_msg">${rank}위 카테고리가 존재하지않습니다.</div>`);
        }
    });
    

    // 햄버거 메뉴 기능
    $('#hamburgerBtn').on('click', function() {
        $('#sideMenu').addClass('active');
        $('.modal-box.benefit').removeClass('active');
        $('#sideMenuOverlay').addClass('active');
    });

    if($(window).width() <= 1100){
        $('#mobileBeneBtn').on('click', function() {
            $('.bene_list').empty();
            temp_bene('mobile');

            $('.modal-box.benefit').addClass('active');
            $('#sideMenu').removeClass('active');
            $('#sideMenuOverlay').addClass('active');
        });

        $('.modal-btn').on('click', function(){
            $('.modal-box.benefit').removeClass('active');
            $('#sideMenuOverlay').removeClass('active');
        });
    }

    $('#sideMenuOverlay').on('click', function() {
        $('#sideMenu').removeClass('active');
        $('#sideMenuOverlay').removeClass('active');
        $('.modal-box.benefit').removeClass('active');
    });

    // ESC 키로 메뉴 닫기
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('#sideMenu').removeClass('active');
            $('.modal-box.benefit').removeClass('active');
            $('#sideMenuOverlay').removeClass('active');
        }
    });
    

</script>
