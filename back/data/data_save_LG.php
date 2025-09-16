<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    // 기본 설정 (추후 수정)
    $level = "vvip";

    // 임시 테이블 비우기 (나중에는 조건을 세부 잡아야할듯)
    $del_sql = "DELETE FROM agency_LG_level_benefitTBL";
    $del_query = mysqli_query($mysqli, $del_sql);

    $cert_sql = "SELECT * FROM agency_certiTBL WHERE status = 'Y'";
    $cert_query = mysqli_query($mysqli, $cert_sql);

    $cert_list = [];
    while ($cert_row = mysqli_fetch_assoc($cert_query)) {
        $cert_list[] = $cert_row['ip'];
    }

    // ✅ 로그 함수
    function write_log($msg) {
        $log_dir = __DIR__ . "/logs";
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        $log_file = $log_dir . "/error_" . date("Ymd") . ".log";
        $timestamp = date("[Y-m-d H:i:s]");

        $fp = fopen($log_file, "a");
        if ($fp) {
            fwrite($fp, "$timestamp $msg\n");
            fclose($fp);
        }
    }

    // ✅ uid 생성 함수
    function generate_uid() {
        return uniqid("lg_", true);
    }

    // ✅ 토큰 검증
    $received_token = $_POST['token'] ?? '';
    if (!in_array($received_token, $cert_list)) {
        write_log("❌ 인증 실패: 유효하지 않은 토큰 ($received_token)",$cert_list);
        exit("❌ 인증 실패");
    }

    // ✅ JSON 파싱
    $membership_json = $_POST['membership'] ?? '';
    $data = json_decode($membership_json, true);
    if (!is_array($data)) {
        write_log("❌ JSON 디코딩 실패 또는 데이터 없음");
        exit("❌ 데이터 없음");
    }

    // ✅ 섹션 → 카테고리 맵핑
    $cate_map = [
        "section_0" => "APP,기기",
        "section_1" => "엑티비티",
        "section_2" => "뷰티,건강",
        "section_3" => "쇼핑",
        "section_4" => "생활,편의",
        "section_5" => "푸드",
        "section_6" => "문화,여가",
        "section_7" => "교육",
        "section_8" => "여행,교통",
        "section_9" => "데이터선물"
    ];
    // ✅ DB 저장 루프
    foreach ($data as $section => $benefits) {
        $cate = $cate_map[$section] ?? null;
        if (!$cate || !is_array($benefits)) {
            write_log("⚠ 섹션 오류 또는 빈 데이터: $section");
            continue;
        }

        foreach ($benefits as $benefit_name => $info) {
            $detail = $info['detail'];
            $re_detail = str_replace('"', '\"', $detail);
            $per = $info['day'];
            $re_per = str_replace('"', '\"', $per);

            $uid = generate_uid();

            $sql = "
                INSERT INTO agency_LG_level_benefitTBL 
                (level, cate, benefit_name, detail, period, uid) 
                VALUES (?, ?, ?, ?, ?, ?)
            ";

            $stmt = mysqli_prepare($mysqli, $sql);
            if (!$stmt) {
                write_log("❌ prepare 실패: " . mysqli_error($mysqli));
                continue;
            }
            
            if (!mysqli_stmt_bind_param($stmt, "ssssss", $level, $cate, $benefit_name, $re_detail, $re_per, $uid)) {
                write_log("❌ bind 실패: " . mysqli_stmt_error($stmt) . " | benefit: $benefit_name");
                continue;
            }

            if (!mysqli_stmt_execute($stmt)) {
                write_log("❌ execute 실패: " . mysqli_stmt_error($stmt) . " | benefit: $benefit_name");
                continue;
            }

            mysqli_stmt_close($stmt);  // 반복 시 안정성 보장
        }
    }
    echo "✔ DB 저장 완료";
?>
