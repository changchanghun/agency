<?php 
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    $user_id = $_SESSION["user_id"];

    $DATA = [];

    $member_sql = "SELECT 
                        * 
                    FROM
                        agency_memberTBL
                    WHERE
                        id = '{$user_id}'
                    AND
                        status = 'Y'
                    ";

    $member_query = mysqli_query($mysqli, $member_sql);
    $member_row = mysqli_fetch_array($member_query);

    $user_data = array(
        "id"    => $member_row["id"],
        "lev"   => $member_row["lev"],        
        "ins_time"  => $member_row["ins_time"],
        "way"       => $member_row["way"],
        "email"     => $member_row["email"],
        "ph"        => $member_row["ph"],
        "name"      => $member_row["name"],
        "type"      => $member_row["type"],
        "fir_flag"  => $member_row["fir_flag"],
        "age"       => $member_row["age"],
    );

    $DATA["user_data"] = $user_data;

    # 접속회원의 통신사와 레벨을 받아서 보여지게할 혜택 
    # 본인 레벨에 맞게 할수있는 방법 없을까 ...
    $agency_benefit_sql = "SELECT 
                                * 
                            FROM 
                                agency_{$member_row['way']}_level_benefitTBL 
                            WHERE 
                                status = 'Y'
                            ";
    
    $agency_benefit_query = mysqli_query($mysqli, $agency_benefit_sql);

    $benefit_arr = [];
    foreach($agency_benefit_query as $agency_benefit_row){
        $benefit_arr[$agency_benefit_row["cate"]][$agency_benefit_row["benefit_name"]]["detail"] = $agency_benefit_row["detail"];
        $benefit_arr[$agency_benefit_row["cate"]][$agency_benefit_row["benefit_name"]]["period"] = $agency_benefit_row["period"];
    }
    
    $DATA["benefit"] = $benefit_arr;

    # 회원의 현재 설정한 카테고리
    $use_cate_sql = "SELECT 
                        * 
                    FROM 
                        agency_mem_useTBL 
                    WHERE 
                        id = '{$member_row['id']}' 
                    AND 
                        status = 'Y'
                    ";

    $use_cate_query = mysqli_query($mysqli,$use_cate_sql);
    
    $use_cate_arr = [];
    if(mysqli_num_rows($use_cate_query) > 0){
        foreach($use_cate_query as $use_cate_row){
            $use_cate_arr[] .= $use_cate_row["cate"];
        }
    }

    $DATA["use_cate"] = $use_cate_arr;

    # 즐겨찾기 리스트
    $fav_list_sql = "SELECT
                            *
                        FROM
                            agency_use_placeTBL
                        WHERE
                            id = '{$member_row['id']}'
                        AND
                            status = 'Y'
                        ";

    $fav_list_row = mysqli_fetch_array(mysqli_query($mysqli, $fav_list_sql));
    $fav_list_arr = [];

    for ($i = 1; $i <= 5; $i++) {
        $key = $fav_list_row["place{$i}"];
        $value = $fav_list_row["place_name{$i}"];

        if ($key) {
            $fav_list_arr[] = array(
                                "place" => $key,
                                "place_name" => $value,
                            );
        }
    }

    $DATA["fav_list"] = $fav_list_arr;

    # 통신사이름, 통신사별 레벨정리
    $agency_list_sql = "SELECT 
                            *
                        FROM 
                            agency_typeTBL 
                        WHERE 
                            status = 'Y'
                        ";
    
    $agency_list_query = mysqli_query($mysqli,$agency_list_sql);

    $agency_data = [];
    foreach($agency_list_query as $agency_row){
        // 레벨 정리
        $agency_data[$agency_row["agency"]][$agency_row["level"]] = $agency_row["cond"];
    }

    $DATA["common"] = $agency_data;

    $cate_data = [];
    $lg_cate_sql = "SELECT cate FROM agency_LG_level_benefitTBL WHERE status = 'Y' GROUP BY cate";
    $lg_cate_query = mysqli_query($mysqli, $lg_cate_sql);
    foreach($lg_cate_query as $lg_row){
        $cate_data["LG"][] = $lg_row["cate"];
    }
    
    $sk_cate_sql = "SELECT cate FROM agency_SK_level_benefitTBL WHERE status = 'Y' GROUP BY cate";
    $sk_cate_query = mysqli_query($mysqli, $sk_cate_sql);
    foreach($sk_cate_query as $sk_row){
        $cate_data["SK"][] = $sk_row["cate"];
    }

    $kt_cate_sql = "SELECT cate FROM agency_KT_level_benefitTBL WHERE status = 'Y' GROUP BY cate";
    $kt_cate_query = mysqli_query($mysqli, $kt_cate_sql);
    foreach($kt_cate_query as $kt_row){
        $cate_data["KT"][] = $kt_row["cate"];
    }
    
    $DATA["cate"] = $cate_data;

    $age_data = [];
    $age_rank_sql = "SELECT 
                        a.id,
                        a.age,
                        a.way,
                        b.cate
                    FROM 
                        agency_memberTBL a 
                    JOIN
                        agency_mem_useTBL b ON a.id = b.id
                    WHERE 
                        a.status = 'Y'
                    AND
                        b.status = 'Y'
                    ";
    $age_rank_query = mysqli_query($mysqli, $age_rank_sql);

    $top_age_data = [];
    $age_data = [];

    foreach ($age_rank_query as $age_rank) {
        $way = $age_rank["way"];
        $age = $age_rank["age"];
        $cate = $age_rank["cate"];

        // 카운트 누적
        $age_data[$way][$age][$cate] = ($age_data[$way][$age][$cate] ?? 0) + 1;

        // 현재까지의 카테고리 count 목록
        $cate_counts = $age_data[$way][$age];

        // 내림차순 정렬
        arsort($cate_counts);

        // 등수별로 묶기
        $ranked_top = [];
        $rank = 1;
        $prev_count = null;

        foreach ($cate_counts as $cate_name => $count) {
            // 최대 3등까지만 유지
            if ($rank > 4) break;

            if ($count === $prev_count) {
                // 이전 등수에 cate 추가
                $last_index = count($ranked_top) - 1;
                $ranked_top[$last_index]["cate"][] = $cate_name;
            } else {
                // 새로운 등수 시작
                $ranked_top[] = [
                    "rank" => $rank,
                    "cate" => [$cate_name]
                ];
                $prev_count = $count;
                $rank++;
            }
        }

        // 저장
        $top_age_data[$way][$age] = $ranked_top;
    }
    // $top_age_data = [];
    // $max_tracker = []; 

    // // 가장 높은것만 가져오는중인데 두번째, 세번째 인기많은것들도 가져와야함
    // foreach ($age_rank_query as $age_rank) {
    //     $way = $age_rank["way"];
    //     $age = $age_rank["age"];
    //     $cate = $age_rank["cate"];

    //     $age_data[$way][$age][$cate] = ($age_data[$way][$age][$cate] ?? 0) + 1;
    //     $count = $age_data[$way][$age][$cate];

    //     $current_max = $max_tracker[$way][$age] ?? 0;

    //     if ($count > $current_max) {
    //         $max_tracker[$way][$age] = $count;
    //         $top_age_data[$way][$age] = [$cate => $count];
    //     } elseif ($count === $current_max) {
    //         $top_age_data[$way][$age][$cate] = $count;
    //     }
    // }

    $DATA["age_rank"] = $top_age_data;
    $DATA_JSON = json_encode($DATA);

    ?>