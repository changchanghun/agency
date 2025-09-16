<?php
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../agency/css/popup_pack.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- 1. 일반 알림 팝업 -->
    <div id="alertModal" class="modal-bg">
        <div class="modal-box">
            <div class="modal-title" id="alertTitle"></div>
            <div class="modal-message" id="alertMessage"></div>
            <button class="modal-btn confirm" id="alertOkBtn">확인</button>
        </div>
    </div>

    <!-- 2. 예/아니오 선택 팝업 -->
    <div id="confirmModal" class="modal-bg">
        <div class="modal-box">
            <div class="modal-title" id="confirmTitle"></div>
            <div class="modal-message" id="confirmMessage"></div>
            <div class="modal-btns">
            <button class="modal-btn confirm" id="confirmYesBtn">예</button>
            <button class="modal-btn cancel" id="confirmNoBtn">아니오</button>
            </div>
        </div>
    </div>

    <!-- 업그레이드된 인풋/POST 팝업 -->
    <div id="inputModal" class="modal-bg">
        <div class="modal-box">
            <div class="modal-title" id="inputTitle"></div>
            <div class="modal-message" id="inputMessage"></div>
            <form id="inputForm">
            <div id="inputFields"></div>
            <div class="modal-btns">
                <button type="button" class="modal-btn confirm" id="inputSubmitBtn">전송</button>
                <button type="button" class="modal-btn cancel" id="inputCancelBtn" style="display:none">취소</button>
            </div>
            </form>
        </div>
    </div>

    <!-- 4. 혜택 알림 팝업 -->
    <div id="beneModal" class="modal-bg">
        <div class="modal-box">
            <div class="modal-title" id="alertTitle2"></div>
            <div class="modal-message">혜택 : <span id="alertMessage2"></span></div>
            <div class="modal-message">횟수 : <span id="alertMessage3"></span></div>
            <button class="modal-btn confirm" id="beneOkBtn">확인</button>
        </div>
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script>
    /* 1. 일반 알림 팝업 */
    function showAlertModal(title, message, callback) {
        $('#alertTitle').text(title);
        $('#alertMessage').text(message);
        $('#alertModal').addClass('active');
        window._alertCallback = callback;
    }

    $('#alertOkBtn').on('click', function() {
        $('#alertModal').removeClass('active');
        if (window._alertCallback) window._alertCallback();
        window._alertCallback = null;
    });

    /* 2. 예/아니오 선택 팝업 */
    function showConfirmModal(title, message, yesCallback, noCallback) {
        $('#confirmTitle').text(title);
        $('#confirmMessage').text(message);
        $('#confirmModal').addClass('active');
        window._confirmYes = yesCallback;
        window._confirmNo = noCallback;
    }

    $('#confirmYesBtn').on('click', function() {
        $('#confirmModal').removeClass('active');
        if (window._confirmYes) window._confirmYes();
        window._confirmYes = window._confirmNo = null;
    });

    $('#confirmNoBtn').on('click', function() {
        $('#confirmModal').removeClass('active');
        if (window._confirmNo) window._confirmNo();
        window._confirmYes = window._confirmNo = null;
    });

    /**
     * showInputModal
     * @param {string} title - 팝업 제목
     * @param {string} message - 안내 메시지
     * @param {Array} inputs - [{name, label, placeholder, type}] 배열
     * @param {string} postUrl - 전송할 URL
     * @param {function} callback - 응답 콜백
     */

    function showInputModal(title, message, inputs, postUrl, callback, cancel) {
        $('#inputTitle').text(title);
        $('#inputMessage').text(message);
        var $fields = $('#inputFields');
        $fields.empty();
        // 인풋 동적 생성
        inputs.forEach(function(input, idx) {
            var html = `
            <div style="margin-bottom:12px;text-align:left;">
                <label style="display:block;margin-bottom:4px;">${input.label || input.name}</label>
                <input 
                type="${input.type || 'text'}" 
                name="${input.name}" 
                class="modal-input" 
                placeholder="${input.placeholder || ''}" 
                autocomplete="off"
                id="inputField_${idx}"
                >
            </div>
            `;
            $fields.append(html);
        });
        $('#inputModal').addClass('active');
        window._inputPostUrl = postUrl;
        window._inputCallback = callback;
        window._inputFieldNames = inputs.map(i => i.name);

        if(cancel == 'Y'){
            $('#inputCancelBtn').css('display','block');
        }
    }

    $('#inputCancelBtn').on('click', function() {
        $('#inputModal').removeClass('active');
        window._inputPostUrl = window._inputCallback = window._inputFieldNames = null;
    });
    
    $('#inputSubmitBtn').on('click', function() {
        var data = {};
        (window._inputFieldNames || []).forEach(function(name, idx) {
            data[name] = $('#inputField_' + idx).val();
        });

        if (!window._inputPostUrl) return;

        $.ajax({
            type : 'POST',
            url : window._inputPostUrl,
            data : data,
            success : function(res){
                $('#inputModal').removeClass('active');
                if (window._inputCallback) window._inputCallback(res);
                window._inputPostUrl = window._inputCallback = window._inputFieldNames = null;
                return false;
            },error : function(a,b,c){
                console.log(a);
                console.log(b);
                console.log(c);
                alert('관리자에 문의하세요');
                return false;
            }
        })
    });

    /* 4. 일반 알림 팝업 */
    function showBeneModal(title, message, message2, callback) {
        $('#beneModal').addClass('active');

        setTimeout(function() {
            $('#alertTitle2').text(title);
            $('#alertMessage2').text(message);
            $('#alertMessage3').html(message2);
            window._alertCallback = callback;
        }, 200);
    }

    $('#beneOkBtn').on('click', function() {
        $('#beneModal').removeClass('active');
        if (window._alertCallback) window._alertCallback();
        window._alertCallback = null;
    });
</script>