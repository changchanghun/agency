<?php 
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/agency/back/public/dbConn.php"); 

    $id         = $_SESSION['user_id'];

    $user_sql = "SELECT * FROM agency_memberTBL WHERE id = '{$id}'";
    $user_query = mysqli_query($mysqli, $user_sql);
    $user_row = mysqli_fetch_array($user_query);

    if(empty($user_row['id'])){
        unset($_SESSION["user_id"]);
        header('Location:http://chworld2.dothome.co.kr/agency');
        exit();
    }

    $del_user_sql = "DELETE FROM
                            agency_memberTBL
                        WHERE
                            id = '{$id}'
                        AND
                            status = 'Y'
                        ";
    $del_user_query = mysqli_query($mysqli, $del_user_sql);

    $del_user_sql2 = "DELETE FROM
                            agency_mem_useTBL
                        WHERE
                            id = '{$id}'
                        ";
    $del_user_query2 = mysqli_query($mysqli, $del_user_sql2);
    
    $del_user_sql3 = "DELETE FROM
                            agency_use_placeTBL
                        WHERE
                            id = '{$id}'
                        ";
                        
    $del_user_query3 = mysqli_query($mysqli, $del_user_sql3);

    if(!$del_user_query){
        echo "<script>
            alert('실패 : 관리자에게 문의해주세요');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/';
            </script>";
        exit();
    }

    if(!$del_user_query2){
        echo "<script>
            alert('실패 : 관리자에게 문의해주세요');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/';
            </script>";
        exit();
    }

    if(!$del_user_query3){
        echo "<script>
            alert('실패 : 관리자에게 문의해주세요');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/';
            </script>";
        exit();
    }

    unset($_SESSION["user_id"]);
    echo "<script>
            alert('이용해주셔서 감사합니다.');
            window.location.href = 'http://chworld2.dothome.co.kr/agency/';
            </script>";
    exit();