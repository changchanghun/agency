<?php
    include_once('./public/login_public.php');
    include_once('./popup_pack.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>대시보드</title>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=289d13144fdda88c0ecd81e7c27fc0df&libraries=services&autoload=false"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -ms-overflow-style: none;     /* IE, Edge */
            scrollbar-width: none;  
        }
        *::-webkit-scrollbar{
            display:none;
        }

        body {
            font-family: 'Noto Sans KR', sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
            position: relative;
            -ms-overflow-style: none;     /* IE, Edge */
            scrollbar-width: none;        /* Firefox */
        }

        .container::-webkit-scrollbar {
            display: none;                /* Chrome, Safari, Opera */
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 15px;
        }

        .bene_list{
            -ms-overflow-style: none;     /* IE, Edge */
            scrollbar-width: none;        /* Firefox */
        }

        .bene_list::-webkit-scrollbar {
            display: none;                /* Chrome, Safari, Opera */
        }

        .category-buttons{
            -ms-overflow-style: none;     /* IE, Edge */
            scrollbar-width: none;        /* Firefox */
        }

        .category-buttons::-webkit-scrollbar{
            display:none;
        }

        .col-md-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            padding: 0 15px;
        }

        .card {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            /* min-width:360px; */
        }

        .modal-box.benefit{
            display:none;
        }

        .modal-box.benefit.active{
            display:block;
            position:fixed;
            top:50%;
            left:50%;
            transform:translate(-50%, -50%);
            overflow-y:auto;
            z-index:1000;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 15px;
            color: #333;
        }

        .card-text {
            margin-bottom: 10px;
            color: #666;
        }

        #map {
            width: 100%;
            height: 500px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .category-buttons {
            margin: 20px 0;
            max-height: 1000px;
            overflow-y:auto;
            display:flex;
            flex-direction: column;
            gap:20px;
        }

        .bene_list{
            display:flex;
            flex-direction: column;
            gap:20px;
        }

        .box_wrap.active{
            border:1px solid #007bff;
            max-height:300px;
            overflow:hidden;
            border-radius:4px;
            overflow-y:auto;
            background:#e2e0e0;
        }

        .category-btn{
            display:inline-block;
            width:100%;
            padding:8px 0;
            /* margin:10px 0; */            /*수정*/
            background-color:#fff;
            border:1px solid #007bff;
            border-radius: 4px;
            color: #007bff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .category-btn:hover {
            background-color: #007bff;
            color: #fff;
        }
        .category-btn.active{
            background-color:#007bff;
            color: #fff;
        }

        .benefit-btn {
            display: inline-block;
            font-size:14px;
            padding: 5px 16px;
            margin: 5px;
            background-color: #fff;
            border: 1px solid #007bff;
            border-radius: 4px;
            color: #007bff;
            cursor: pointer;
            transition: all 0.3s ease;
            width:90%;
        }
        .benefit-btn:hover {
            background-color: #007bff;
            color: #fff;
        }
        .benefit-btn.active{
            background-color:#007bff;
            color: #fff;
        }

        .store-list {
            max-height: 700px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .store-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .store-item:last-child {
            border-bottom: none;
        }

        .store-name {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .store-address {
            color: #666;
            margin-bottom: 5px;
        }

        .store-distance {
            color: #888;
            font-size: 0.9rem;
        }

        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        /* 햄버거 버튼 */
        .hamburger-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: #007bff;
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 20px;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .hamburger-btn:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        .mobileBeneBtn{
            display:none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background:rgb(202, 36, 157);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 20px;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .mobileBeneBtn:hover{
            background: rgb(150, 36, 116);
            transform: scale(1.1);
        }

        /* 사이드 메뉴 */
        .side-menu {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: right 0.3s ease;
            padding: 80px 20px 20px;
        }
        .side-menu.active {
            right: 0;
        }
        .side-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .side-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .menu-item {
            display: block;
            width: 100%;
            padding: 15px 20px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border: none;
            border-radius: 8px;
            text-align: left;
            font-size: 16px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .menu-item:hover {
            background: #007bff;
            color: white;
            transform: translateX(5px);
        }
        .menu-item i {
            margin-right: 10px;
            font-size: 18px;
        }
    </style>
    <style>
.autocomplete-list {
    position: absolute;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 100%;
    z-index: 1000;
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.autocomplete-item {
    padding: 10px;
    cursor: pointer;
}
.autocomplete-item:hover {
    background: #f0f0f0;
}

#favLocationBtn{
    position: absolute; 
    top: 20px; 
    right:36px; 
    margin-left:10px; 
    font-size:15px;
    padding:4px 12px;
    border-radius:6px;
    border:1px solid #007bff;
    background:#fff;
    color:#007bff;
    cursor:pointer;
}

#addFavBtn{
    position:absolute;
    right:0px;
    top:0;
    height:38px;
    padding:0 10px;
    font-size:15px;
    border-radius:6px;
    border:1px solid #28a745;
    background:#fff;
    color:#28a745;
    cursor:pointer;"
}

#home-btn{
    position:absolute;
    left:0px;
    top:0;
    height:38px;
    padding:0 10px;
    font-size:15px;
    border-radius:6px;
    border:1px solid #28a745;
    background:#fff;
    color:#28a745;
    cursor:pointer;"
}

/* 반응형 */
@media (max-width: 1100px){
    .col-md-4{
        display:none;
    }
    .col-md-8{
        flex:unset;
        width:100%;
        max-width:100%;
    }
    #map{
        height:300px;
    }
    .store-item{
        padding:8px;
    }
    
    #favLocationBtn{
        font-size:10px;
    }

    #addFavBtn{
        font-size:10px;
    }

    #mobileBeneBtn{
        display:block;
    }
    .store-list{
        max-height:400px;
    }
    .box_wrap.active{
        max-height:200px !important;
    }

    .mobile-box-wrap{
        display:block !important;
    }

    .mobile-box button{
        padding:5px 10px;
        color:#fff;
        border-radius:4px;
        font-size:13px;
    }

    .mobile-cate{
        display:flex;
        gap:10px;
        margin:10px 0;
    }
    .mobile-cate .cate-box{
        font-size:12px;
        border-radius:4px;
        border:1px solid #007bff;
        color:#007bff;
        padding:4px 12px;
    }
}

</style>
</head>
<body>
    <!-- 햄버거 버튼 -->
    <button class="hamburger-btn" id="hamburgerBtn">☰</button>
    <button class="mobileBeneBtn" id="mobileBeneBtn">&#128717;</button>
    
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
            <h2 class="page-title"><span class="name"></span>님의 PoFi !</h2>
            <button id="favLocationBtn">위치 즐겨찾기</button>
            <div class="mb-3" style="border-radius:30%; position:relative;">
                <button id="addFavBtn">즐겨찾기 추가</button>
                <input type="text" class="form-control" id="search" name="search" style="border-radius:1rem; padding-left:50px;" oninput="this.value = this.value.replace(/[^ㄱ-ㅎ가-힣a-zA-Z0-9\-]/g, '')" placeholder="예시) 서울도서관">
                <button id="home-btn">&#127968;</div>
                <!-- <div class="search_btn" style="position:absolute; width:38px; height:38px; right:10px; font-size:24px; line-height:38px; text-align:center;">&#128269;</div> -->
                <!-- <label for="find_name" class="form-label">이름</label> -->
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card pc">
                        <div class="card-body user">
                            <h5 class="card-title">회원 정보</h5>
                            <p class="card-text">이름: <span class="name"></span></p>
                            <p class="card-text">통신사: <span class="agency"></span></p>
                            <p class="card-text">등급: <span class="lev"></span></p>
                            <p class="card-text">가입일: <span class="dtm"></span></p>
                        </div>
                    </div>
                    
                    <div class="card mobile">
                        <div class="card-body benefit">
                            <h5 class="card-title">활성화된 혜택</h5>
                            <div class="category-buttons">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div id="map"></div>
                    <div class="mobile-box-wrap" style="display:none; width:100%; background:#fff; border-radius:5px; box-shadow:0 2px 4px rgba(0,0,0,0.1); margin-bottom:20px; border: 1px solid rgba(0,0,0, .125); position:relative;">
                        <div class="mobile-box" style="padding:20px;">
                            <h5>현재 활성 카테고리</h5>
                            <div class="mobile-cate">
                            </div>
                            <button class="change-cate" style="position:absolute; right:15px; top:15px; border:none;" onclick="location.href='upd_cate.php'">
                                ⚙️
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">주변 가게 목록</h5>
                            <div id="storeList" class="store-list">
                                <div class="store-item">조회된 가게가 없습니다</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="./back/process/logout.php" class="logout-btn">로그아웃</a>
            </div>
        </div>
    </div>
    <div id="favLocationModal" style="display:none;position:fixed;z-index:2000;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);">
        <div style="background:#fff;width:80%; min-width:200px; max-width:400px; padding:24px 24px 16px 24px;border-radius:8px;position:fixed; top:50%; left:50%; transform: translate(-50%, -50%); display:flex; flex-flow:column; justify-content:space-around;">
            <h3 style="margin-bottom:16px;">즐겨찾는 위치</h3>
            <ul id="favLocationList" style="list-style:none;padding:0;margin:0 0 16px 0;"></ul>
            <button id="closeFavModal" class="modal-btn" style="margin-top:20px;">확인</button>
        </div>
    </div>

    <div class="modal-box benefit" style="width: 300px; position: fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; z-index:9999; justify-content:center; align-ites:center; border-radius:8px; box-shadow:0 2px 16px rgba(0,0,0,0.2); text-align:center;">
        <div class="modal-title">혜택 활성화</div>
        <div class="bene_list" style= "overflow:scroll;"></div>
        <button class="modal-btn" style="margin-top:20px;">확인</button>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script>
    let rawJson = '<?= $DATA_JSON ?>';
    let cleanJson = rawJson.replace(/[\u0000-\u001F]+/g, "");
    let common_data = JSON.parse(cleanJson);

    if(common_data.user_data.way == "SK"){
        let benefit = common_data.benefit;
        $.each(benefit, function(key, value) {
            $.each(value, function(key2, value2){
                value2.period = `<a href="https://sktmembership.tworld.co.kr/mps/pc-bff/benefitbrand/detail.do?brandId=`+value2.period+`" target="_blank">참고해주세요</a>`;
            });
        });
    }

    // 1. 즐겨찾기 모달 열기/닫기/목록 렌더링
    $('#favLocationBtn').on('click', function() {
        renderFavLocationList();
        $('#favLocationModal').fadeIn(100);
    });
    $('#closeFavModal').on('click', function() {
        $('#favLocationModal').fadeOut(100);
    });

    function renderFavLocationList() {
        const arr = common_data.fav_list;
        const $list = $('#favLocationList');
        $list.empty();
        if(arr.length === 0) {
            $list.append('<li style="color:#888;">저장된 위치가 없습니다.</li>');
        }
        arr.forEach((loc, idx) => {
            
            const $li = $('<li data="'+loc.place+'" style="display:flex;align-items:center;justify-content:space-between;padding:6px 0;border-bottom:1px solid #eee;"></li>');
            const $name = $('<span style="cursor:pointer;flex:1;">['+loc.place_name+']'+loc.place+'</span>');
            const $del = $('<button style="color:#dc3545;background:none;border:none;cursor:pointer;">삭제</button>');
            
            $name.on('click', function() {
                $('#search').val(loc.place).trigger('input');
                setTimeout(function(){
                    $('.autocomplete-item').first().trigger('click');
                }, 300);
                $('#favLocationModal').fadeOut(100);
            });
            
            $del.on('click', function() {
                place = $(this).parent().attr('data');
                $.ajax({
                    type:'post',
                    url:"./back/process/upd_place.php?del=Y",
                    data : {
                        del_place : place
                    },
                    success:function(res){
                        console.log(res);
                        if(res == 'true'){
                            // 완료 알럿 넣을까
                            console.log(res);
                            location.reload();
                            $(this).css('display','none');
                        }else{
                            console.log(res);
                            showAlertModal('삭제실패','관리자에게 문의해주세요.')
                            return false;
                        }
                    },
                    error : function(a,b,c){
                        console.log(a);
                        console.log(b);
                        console.log(c);
                    }
                })
            });

            $li.append($name).append($del);
            $list.append($li);
        });
    }

    // 즐겨찾기 추가
    $('#addFavBtn').on('click', function() {
        const val = $('#search').val().trim();
        if(!val) return showAlertModal('알림','위치를 입력해주세요.'); 
        let arr = $('#search');
        placeModal(val);
    });

    // 카카오 유저일때 필수 값
    if(common_data.user_data.ph == '0000' || common_data.user_data.name == '-'){
        dataModal();
    }

    if(common_data.user_data.name == 'ckdgns'){
        dataModal();
    }

    // 첫 가입자일때 필수 값
    if(common_data.user_data.fir_flag == 'Y'){
        window.location.href = 'setting_page.php';
    }

    // 정보 찍어주기
    let date = common_data.user_data.ins_time.split(" ")[0];
    $('.name').text(common_data.user_data.name);
    $('.dtm').text(date);
    $('.agency').text(common_data.user_data.way);
    $('.lev').text(common_data.user_data.lev);
    
    // 모바일 카테고리
    common_data.use_cate.forEach(function(item) {
        let box_wrap = $("<div></div>")
            .addClass("cate-box")
            .append(item);

        $('.mobile-cate').append(box_wrap);
    });

    let use_temp = [];
    let use_arr_benefit = {};
    let detail_list = {};
    let period_list = {};

    // 카테고리 혜택 활성화
    function temp_bene(temp){

        let container;
        let arr_cate = common_data.use_cate;

        if(temp == null){
            container = $('.category-buttons');
        }else{
            container = $('.modal-box.benefit .bene_list');
        }

        $.each(arr_cate, function(idx, cate_name) {
            if (!use_arr_benefit[cate_name]) {
                use_arr_benefit[cate_name] = {}; 
            }
            let benefits = common_data.benefit[cate_name];
            $.each(benefits, function(benefit_name, bene_info) {
                temp_detail = bene_info['detail'];
                temp_period = bene_info['period'];
                use_temp.push(benefit_name);
                if (!use_arr_benefit[cate_name][benefit_name]) {
                    use_arr_benefit[cate_name][benefit_name] = {};
                }
                use_arr_benefit[cate_name][benefit_name]['detail'] = temp_detail;
                use_arr_benefit[cate_name][benefit_name]['period'] = temp_period;
            });
        });

        $.each(use_arr_benefit, function(category, benefitList){
            let btn = $("<button></button>")
                .addClass("category-btn")
                .text(category)
                .click(function(){
                    if($(this).hasClass("active")){
                        $('.benefit-group').hide();
                        $('.category-btn').removeClass("active");
                        $('.box_wrap').removeClass("active");
                    }else{
                        $('.benefit-group').hide();
                        $('.category-btn').removeClass("active");
                        $('.box_wrap').removeClass("active");
                        $(this).closest('.box_wrap').addClass("active");
                        $(this).next(".benefit-group").show()
                            .css({
                                "text-align":"center"
                            })
                        $(this).toggleClass("active");
                    }
                });

            let benefitWrapper = $("<div></div>")
                .addClass("benefit-group")
                .css("display","none");

            $.each(benefitList, function(benefitName, info2){
                temp2_detail = info2["detail"];
                temp2_period = info2["period"];
                detail_list[benefitName] = temp2_detail;
                period_list[benefitName] = temp2_period;
                let benefitBtn = $("<button></button>")
                    .addClass("benefit-btn")
                    .text(benefitName)
                    .click(function(){
                        $('.benefit-btn').removeClass("active");
                        $(this).toggleClass("active");
                        searchNearbyStores(benefitName, true);
                    });
                benefitWrapper.append(benefitBtn);
            });

            // 추가
            let box_wrap = $("<div></div>")
                .addClass("box_wrap")
                .append(btn)
                .append(benefitWrapper);

            container.append(box_wrap);
        })
    }

    temp_bene();

    kakao.maps.load(function(){
        // 위치 관련 변수
        let myPosition = { lat: 37.566295, lng: 126.977945 };
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                myPosition.lat = position.coords.latitude;
                myPosition.lng = position.coords.longitude;
                setMapCenter(myPosition.lat, myPosition.lng);
                setMyMarker(myPosition.lat, myPosition.lng);
                searchAllCategories();
            }, function() {
                setMapCenter(myPosition.lat, myPosition.lng);
                setMyMarker(myPosition.lat, myPosition.lng);
                searchAllCategories();
            });

        } else {
            setMapCenter(myPosition.lat, myPosition.lng);
            setMyMarker(myPosition.lat, myPosition.lng);
            searchAllCategories();
        }


        // 지도 초기화
        var mapContainer = document.getElementById('map');
        var mapOption = {
            center: new kakao.maps.LatLng(myPosition.lat, myPosition.lng),
            level: 3
        };
        var map = new kakao.maps.Map(mapContainer, mapOption);

        // 마커 배열
        var markers = [];
        var myMarker = null;
        let allStoreList = [];

        // 내 위치 마커(파란색)
        function setMyMarker(lat, lng) {
            if (myMarker) myMarker.setMap(null);
            myMarker = new kakao.maps.Marker({
                position: new kakao.maps.LatLng(lat, lng),
                image: new kakao.maps.MarkerImage(
                    'https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png',
                    new kakao.maps.Size(24, 35), {offset: new kakao.maps.Point(12, 35)}
                )
            });
            myMarker.setMap(map);
        }
        function setMapCenter(lat, lng) {
            map.setCenter(new kakao.maps.LatLng(lat, lng));
        }

        // 카테고리별 자동 검색 및 마커(빨간색) 표시
        function searchAllCategories() {
            removeAllMarkers();
            allStoreList = [];
            var categories = use_temp;
            let pending = categories.length;
            categories.forEach(function(category) {
                searchNearbyStores(category, true, function(){
                    pending--;
                    if(pending === 0) renderAllStoreList();
                });
            });
        }

        // 주변 가게 검색 함수 (isAuto: true면 마커만 찍음, false면 리스트도 표시, cb는 자동검색 완료 콜백)
        function searchNearbyStores(keyword, isAuto = false, cb) {
            var places = new kakao.maps.services.Places();
            var bounds = new kakao.maps.LatLngBounds();
            places.keywordSearch(keyword, function(results, status) {
                if (status === kakao.maps.services.Status.OK) {
                    if (!isAuto) {
                        var storeList = document.getElementById('storeList');
                        storeList.innerHTML = '';
                    }
                    results.forEach(function(place) {
                        var distance = getDistance(
                            myPosition.lat,
                            myPosition.lng,
                            place.y,
                            place.x
                        );

                        if(!place.place_name.includes(keyword)){
                            return;
                        }

                        if (distance <= 2.5) {
                            // 빨간색 마커
                            var marker = new kakao.maps.Marker({
                                position: new kakao.maps.LatLng(place.y, place.x),
                                image: new kakao.maps.MarkerImage(
                                    'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                                    new kakao.maps.Size(32, 32), {offset: new kakao.maps.Point(16, 32)}
                                )
                            });
                            marker.setMap(map);
                            markers.push(marker);
                            bounds.extend(new kakao.maps.LatLng(place.y, place.x));

                            // 매장 정보 저장 (자동검색 시만)
                            if (isAuto) {
                                allStoreList.push({
                                    place_name: place.place_name,
                                    road_address_name: place.road_address_name,
                                    address_name: place.address_name,
                                    distance: distance,
                                    lat: place.y,
                                    lng: place.x,
                                    keyword: keyword
                                });
                                // 마커에 정보 연결
                                kakao.maps.event.addListener(marker, 'click', function() {
                                    moveToCoords(place.y, place.x);
                                    let temp_name = place.place_name;
                                    showBeneModal(
                                        place.place_name,
                                        detail_list[keyword],
                                        period_list[keyword]
                                    );
                                });
                            }
                            // 리스트 표시(카테고리 버튼 클릭 시)
                            if (!isAuto) {
                                var storeItem = document.createElement('div');
                                storeItem.className = 'store-item';
                                storeItem.innerHTML = `
                                    <div class=\"store-name\">${place.place_name}</div>
                                    <div class=\"store-address\">${place.road_address_name}</div>
                                    <div class=\"store-distance\">거리: ${distance.toFixed(1)}km</div>
                                `;
                                storeList.appendChild(storeItem);
                                // 리스트 클릭 시 팝업
                                storeItem.onclick = function() {
                                    moveToCoords(place.y, place.x);
                                    showBeneModal(
                                        place.place_name,
                                        detail_list[keyword],
                                        period_list[keyword]
                                    );
                                }

                                kakao.maps.event.addListener(marker, 'click', function() {
                                    moveToCoords(place.y, place.x);
                                    showBeneModal(
                                        place.place_name,
                                        detail_list[keyword],
                                        period_list[keyword]
                                    );
                                });
                            }
                        }
                    });
                    if (!isAuto) {
                        if (markers.length > 0) {
                            map.setBounds(bounds);
                        } else {
                            var noneItem = document.createElement('div');
                            noneItem.className = 'store-item';
                            noneItem.innerHTML = `<div class=\"store-none\">검색된 가게가 없습니다.</div>`;
                            storeList.appendChild(noneItem);
                        }
                    }
                }else{
                    var storeList = document.getElementById('storeList');
                    var noneItem = document.createElement('div');
                    storeList.innerHTML = '';
                    noneItem.className = 'store-item';
                    noneItem.innerHTML = `<div class=\"store-none\">검색된 가게가 없습니다.</div>`;
                    storeList.appendChild(noneItem);
                }
                if(cb) cb();
            }, {
                location: new kakao.maps.LatLng(myPosition.lat, myPosition.lng),
                radius: 5000
            });
        }

        // 전체 매장 리스트를 주변가게목록에 출력
        function renderAllStoreList() {
            var storeList = document.getElementById('storeList');
            storeList.innerHTML = '';
            if (allStoreList.length === 0) {
                var noneItem = document.createElement('div');
                noneItem.className = 'store-item';
                noneItem.innerHTML = `<div class=\"store-none\">검색된 가게가 없습니다.</div>`;
                storeList.appendChild(noneItem);
                return;
            }
            allStoreList.sort(function(a, b) { return a.distance - b.distance; });
            allStoreList.forEach(function(place) {
                var storeItem = document.createElement('div');
                storeItem.className = 'store-item';
                storeItem.innerHTML = `
                    <div class=\"store-name\">${place.place_name}</div>
                    <div class=\"store-address\">${place.road_address_name}</div>
                    <div class=\"store-distance\">거리: ${place.distance.toFixed(1)}km</div>
                `;
                storeList.appendChild(storeItem);
                // 리스트 클릭 시 팝업
                storeItem.onclick = function() {
                    moveToCoords(place.lat, place.lng);
                    showBeneModal(
                        place.place_name,
                        detail_list[place.keyword],
                        period_list[place.keyword]
                    );
                }
            });
        }

        // 모든 마커 제거
        function removeAllMarkers() {
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];
        }

        // 두 지점 간의 거리 계산 (km)
        function getDistance(lat1, lon1, lat2, lon2) {
            var R = 6371;
            var dLat = deg2rad(lat2 - lat1);
            var dLon = deg2rad(lon2 - lon1);
            var a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var distance = R * c;
            return distance;
        }
        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }

        // 검색 인풋 자동완성
        var $search = $('#search');
        var $searchBox = $search.parent();
        var $autoList = $('<div class="autocomplete-list"></div>').css({top: $search.outerHeight() + 2, left: 0, width: '100%'}).hide();
        $searchBox.css('position', 'relative').append($autoList);
        var autoMarkers = [];
        $search.on('input', function() {
            var val = $(this).val();
            $autoList.empty().hide();
            if (!val) return;

            // 1. 주소 검색 (geocoder)
            var geocoder = new kakao.maps.services.Geocoder();
            geocoder.addressSearch(val, function(result, status) {
                if (status === kakao.maps.services.Status.OK && result.length > 0) {
                    result.forEach(function(addr) {
                        var $item = $('<div class="autocomplete-item"></div>').text(addr.address_name);
                        $item.data('place', {
                            place_name: addr.address_name,
                            road_address_name: addr.road_address ? addr.road_address.address_name : '',
                            address_name: addr.address_name,
                            y: addr.y,
                            x: addr.x
                        });
                        $autoList.append($item);
                    });
                    $autoList.show();
                } else {
                    // 2. 장소 검색 fallback
                    var places = new kakao.maps.services.Places();
                    places.keywordSearch(val, function(results, status) {
                        if (status === kakao.maps.services.Status.OK) {
                            results.forEach(function(place) {
                                var $item = $('<div class="autocomplete-item"></div>').text(place.place_name + ' (' + place.road_address_name + ')');
                                $item.data('place', place);
                                $autoList.append($item);
                            });
                            $autoList.show();
                        }
                    }, {
                        location: new kakao.maps.LatLng(myPosition.lat, myPosition.lng),
                        radius: 5000
                    });
                }
            });
        });
        $autoList.on('click', '.autocomplete-item', function() {
            var place = $(this).data('place');
            $search.val(place.road_address_name || place.address_name);
            $autoList.empty().hide();
            setMapCenter(place.y, place.x);
            setMyMarker(place.y, place.x);
            myPosition.lat = parseFloat(place.y);
            myPosition.lng = parseFloat(place.x);
            searchAllCategories();
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.autocomplete-list, #search').length) {
                $autoList.empty().hide();
            }
        });

        // 기존 카테고리 버튼 클릭시도 내 위치 기준으로 검색
        window.searchNearbyStores = function(keyword) {
            removeAllMarkers();
            searchNearbyStores(keyword, false);
        }

        // 햄버거 메뉴 기능
        $('#hamburgerBtn').on('click', function() {
            $('#sideMenu').addClass('active');
            $('.modal-box.benefit').removeClass('active');
            $('#sideMenuOverlay').addClass('active');
        });

        $('.modal-btn').on('click', function(){
            $('.modal-box.benefit').removeClass('active');
            $('#sideMenuOverlay').removeClass('active');
        });

        $(document).on('click', '#mobileBeneBtn , .choice-bene', function(){
            $('.bene_list').empty();
            temp_bene('mobile');

            $('.modal-box.benefit').addClass('active');
            $('#sideMenu').removeClass('active');
            $('#sideMenuOverlay').addClass('active');
        })

        $('#sideMenuOverlay').on('click', function() {
            $('#sideMenu').removeClass('active');
            $('#sideMenuOverlay').removeClass('active');
            $('.modal-box.benefit').removeClass('active');
        });

        // 현재위치로 이동
        $('#home-btn').on('click', function(){
            const coords = new kakao.maps.LatLng(myPosition.lat, myPosition.lng);
            map.panTo(coords);
            currentMarker.setMap(null);
            currentCircle.setMap(null);
        });

        // ESC 키로 메뉴 닫기
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('#sideMenu').removeClass('active');
                $('.modal-box.benefit').removeClass('active');
                $('#sideMenuOverlay').removeClass('active');
            }
        });

        // 포커스 이동
        let currentMarker = null;
        let currentCircle = null;
        function moveToCoords(lat, lng) {

            const coords = new kakao.maps.LatLng(lat, lng);
            map.panTo(coords);

            // 기존 마커 제거
            if (currentMarker) currentMarker.setMap(null);

            currentMarker = new kakao.maps.Marker({
                position: coords,
                map: map
            });

            // 기존 원 제거
            if (currentCircle) currentCircle.setMap(null);

            // 새 원 생성
            currentCircle = new kakao.maps.Circle({
                center: coords,
                radius: 50,
                strokeWeight: 2,
                strokeColor: '#00aaff',
                strokeOpacity: 0.8,
                fillColor: '#00aaff',
                fillOpacity: 0.3,
                map: map
            });
        }

    });
    
    // 회원 추가 정보
    // title, message, inputs[], postUrl, callback
    function dataModal(){
        showInputModal('회원정보 입력', '아래 정보를 모두 입력하세요.',
        [
            {name:'name', label:'이름', placeholder:'한글 또는 영어만 입력 가능'},
            {name:'phone', label:'전화번호', placeholder:'- 제외 숫자 입력'}
        ],
        './back/process/add_data.php',
        function(res){ 

            let err_msg = '';

            switch(res){
                case "false1" :
                    err_msg = '값을 모두 입력해주세요';
                    break;
                case "false2" :
                    err_msg = '이름은 한글 또는 영어만 입력 가능합니다';
                    break;
                case "false3" :
                    err_msg = '전화번호 형식이 맞지않습니다';
                    break;
                case "false4" :
                    err_msg = '이미 가입한 번호입니다';
                    break;
            }

            if(res == 'true'){
                showAlertModal('등록 완료','등록되었습니다',function(){location.reload()});
                return false;
            }else{
                showAlertModal('등록 실패',err_msg,function(){location.reload()});
                return false;
            }
        },
)
    }

    // 즐겨찾기 추가
    function placeModal(val){
        showInputModal('즐겨찾기 추가', '저장할 이름을 입력해주세요.',
        [
            {name:'place_name', label:'저장할 이름'},
        ],
        `./back/process/upd_place.php?place=${val}`,
        function(res){ 

            let err_msg = '';
            console.log(res);

            switch(res){
                case "false1" :
                    err_msg = '이미 등록된 위치입니다.';
                    break;
                case "false2" :
                    err_msg = '최대 5개까지 저장할 수 있습니다.';
                    break;
                case "false3" :
                    err_msg = '이름 입력은 필수입니다.';
                    break;
            }

            if(res == 'true'){
                showAlertModal('등록 완료','등록되었습니다',function(){location.reload()});
                return false;
            }else{
                showAlertModal('등록 실패',err_msg,function(){location.reload()});
                return false;
            }
        },"Y")
    }

</script>
