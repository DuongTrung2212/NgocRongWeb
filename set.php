<?php
if (session_status() == PHP_SESSION_NONE) {
    // Nếu chưa khởi động, tiến hành khởi động phiên làm việc
    session_start();
}
include('connect.php');
if(isset($_SESSION['username'])){
$_dangnhap = 1;
$_tk = $_SESSION['username'];

	$sql = "SELECT * FROM account WHERE username  ='$_tk'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
$_id = $row['id'];
$_username = htmlspecialchars($row['username']);
$_anh_web = $row['anh_web'];
$_vnd = $row['vnd'];
$_tongnap = $row['tongnap'];
$_status = $row['active'];
$_gioithieu = $row['gioithieu'];
$_mabaove = $row['mabaove'];
$_is_admin = $row['is_admin'];
	$sql1 = "SELECT *,JSON_EXTRACT(data_task, '$[0]') AS data_task,JSON_EXTRACT(data_point, '$[1]') AS sucmanh,SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(pet, '$[1]')), ',', 2), ',', -1) AS detu_sm FROM player WHERE account_id  ='$_id'";
                            $result1 = mysqli_query($conn, $sql1);
                            $row1 = mysqli_fetch_assoc($result1);
$_name = $row1['name'];
$_head = $row1['head'];    
$_data_task = $row1['data_task'];
$_gender = $row1['gender'];
$value = $row1['sucmanh'];
$value_dt = $row1['detu_sm'];
}else{
$_dangnhap = 0;
}
?>