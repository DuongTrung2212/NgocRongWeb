<?php
include'head.php';
if($_dangnhap == 1){
$sql4 = "SELECT * FROM task_main_template WHERE id ='$_data_task'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);  
                            if($_gender == 0){
                            $hanh_tinh = "trái đất";
                            }   
                            if($_gender == 1){
                            $hanh_tinh = "namec";
                            }
                            if($_gender == 2){
                            $hanh_tinh = "xayda";
                            }
                                        if ($value != '') {
                                            if ($value > 1000000000) {
                                                $suc_manh = number_format($value / 1000000000, 1, '.', '') . ' tỷ';
                                            } elseif ($value > 1000000) {
                                                $suc_manh = number_format($value / 1000000, 1, '.', '') . ' Triệu';
                                            } elseif ($value >= 1000) {
                                                $suc_manh = number_format($value / 1000, 1, '.', '') . ' k';
                                            } else {
                                                $suc_manh = number_format($value, 0, ',', '');
                                            }
                                        } else {
                                            $suc_manh = 'Không có chỉ số sức mạnh';
                                        }
               if ($value_dt != '') {
                                            if ($value_dt > 1000000000) {
                                                $suc_manh_dt = number_format($value_dt / 1000000000, 1, '.', '') . ' tỷ';
                                            } elseif ($value_dt > 1000000) {
                                                $suc_manh_dt = number_format($value_dt/ 1000000, 1, '.', '') . ' Triệu';
                                            } elseif ($value_dt >= 1000) {
                                                $suc_manh_dt = number_format($value_dt / 1000, 1, '.', '') . ' k';
                                            } else {
                                                $suc_manh_dt = number_format($value_dt, 0, ',', '');
                                            }
                                        } else {
                                            $suc_manh_dt = 'Không đệ tử';
                                        }
?>
<div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
Tên Nhân Vật : <?php echo $_name;?>
</br>
Nhiện Vụ : <?php echo $row4['NAME'];?>
</br>
Ảnh Đại Diện : <a href="./avatar.php">Đổi Avatar</a></br>
Hành Tinh : <?php echo$hanh_tinh;?>
</br>
Sức Mạnh : <?php echo$suc_manh;?>
</br>
Sức Mạnh Đệ : <?php echo$suc_manh_dt;?>
</br>
Số Dư : <?php echo$_vnd;?>đ
</br>
Đã Nạp :<?php echo$_tongnap;?>đ
</br>
Avatar Đang Dùng : <img class="avatar" src="<?php echo $_anh_web;?>" style="width: 50px; height: 55px;">
</div>
<?php
}else{
echo'<script>
							window.location="login.php";
		</script>';
}
?>