<?php
    include_once('./public/login_public.php');
    include_once('./popup_pack.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>카테고리 설정</title>
    <link rel="stylesheet" href="../agency/css/setting_page.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div id="setupPage">
  <div id="qnaBox"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script>
    let rawJson = '<?= $DATA_JSON ?>';
    let cleanJson = rawJson.replace(/[\u0000-\u001F]+/g, "");
    let common_data = JSON.parse(cleanJson);
    
    $('#setupPage').show();
    let userAnswers = {};
    let cate_arr = [];

    $.each(common_data.cate[common_data.user_data.way], function(idx,vlu){
      cate_arr.push(vlu);
    });

    let btnHtml = '';
    $.each(cate_arr, function(i, cate){
      btnHtml += `<button class="qna-btn cate" data-value="${cate}">${cate}</button>\n`;
    });
    
    $('#qnaBox').html(`
      <div class="qna-fadein">
        <div style="font-size:1.2rem;margin-bottom:24px;">관심 카테고리를 고르세요</div>
        ${btnHtml}
        <div style="display:flex; justify-content: space-around;">
          <div class="qna-back" id="qnaBackBtn">&larr; 이전으로</div>
          <div class="qna-front" id="qnaFrontBtn">설정 &rarr;</div>
        </div>
      </div>
    `);

    $('.qna-btn.cate').on('click', function(){
      $(this).toggleClass('active');

      if($(this).hasClass('active')){
        $(this).css({
                    'background-color':'#007bff',
                    'color':'#fff'
        })
      }else{
        $(this).css({
                    'background-color':'#f1f1f1',
                    'color':'#007bff'
        })
      }
    });

    $('#qnaFrontBtn').on('click', function() {
      $cata_arr = [];

      $('.qna-btn.cate.active').each(function(){
        $cata_arr.push($(this).data('value'));
        userAnswers.cate = $cata_arr;
      });
      submitQna();
    });
    
    $('#qnaBackBtn').on('click', function() {
      location.href = '/agency/main.php';
    });

    function submitQna() {
    $('#qnaBox').html('<div class="qna-fadein" style="font-size:1.1rem;">설정 정보를 저장 중입니다...</div>');
    $.post('./back/process/upd_cate_process.php', userAnswers, function(res) {
      // 성공 시 메인으로 이동
      if(res == 'true'){
        location.href = '/agency/main.php';
      }else{
        alert('카테고리를 선택해주세요');
        location.href = '/agency/upd_cate.php';
      }
    });
  }
    
</script>