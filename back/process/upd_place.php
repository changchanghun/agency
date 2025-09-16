<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id             = $_SESSION['user_id'];
    $place          = trim($_REQUEST['place']);
    $place_name     = trim($_REQUEST['place_name']);
    
    // 삭제시
    $del           = $_REQUEST['del'];
    $del_place     = $_REQUEST['del_place'];

    if(!empty($place)){
        if(empty($place_name)){
            echo "false3";
            exit();
        }
    }
    
    $mem_sql = "SELECT * FROM agency_memberTBL WHERE id = '{$id}' AND status = 'Y'";
    $mem_row = mysqli_fetch_array(mysqli_query($mysqli, $mem_sql));
    
    if(empty($mem_row['id'])){
        echo "error";
        exit();
    }

    $place_sql = "SELECT * FROM agency_use_placeTBL WHERE id = '{$id}' AND status = 'Y'";
    $place_row = mysqli_fetch_array(mysqli_query($mysqli, $place_sql));
    
    if($place_row['id']){

        $count = 0;
        $difCount = 1;
        $del_num;
        $temp_arr = [];

        for ($i = 1; $i <= 5; $i++) {
            $key = $place_row["place{$i}"];

            if($del != 'Y'){
                if ($key == $place) {
                    echo "false1";
                    exit();
                }
            }
            
            if (!empty($key)){
                $count++;
            }else{
                $temp_arr[] .= $i;
            }

            if ($key == $del_place){
                $del_num = $i;
            }
            
        }
        
        # 삭제 sql
        if($del == 'Y'){
            $upd_del_sql = "UPDATE
                                agency_use_placeTBL
                            SET
                                place{$del_num} = null,
                                place_name{$del_num} = null
                            WHERE
                                id = '{$id}'
                            AND
                                status = 'Y'
                            ";
            $upd_del_query = mysqli_query($mysqli, $upd_del_sql);

            if(!$upd_del_query){
                echo "false";
                exit();
            }

            echo "true";
            exit();
        }

        if($count == 5 || $difCount == 6){
            echo "false2";
            exit();
        }

        $min_count = min($temp_arr);

        $upd_place_sql = "UPDATE 
                            agency_use_placeTBL 
                        SET 
                            place{$min_count} = '{$place}', 
                            place_name{$min_count} = '{$place_name}' 
                        WHERE 
                            id = '{$id}'
                        AND 
                            status = 'Y' 
                        ";
        
        mysqli_query($mysqli, $upd_place_sql);
        echo "true";
        exit();
    }

    $ins_place_sql = "INSERT INTO agency_use_placeTBL (id,place1,place_name1) VALUES ('{$id}','{$place}','{$place_name}')";
    mysqli_query($mysqli, $ins_place_sql);
    echo "true";
    exit();
