<?php
include('head.php');
$today1 = date("YmdHi");
 if (isset($_GET['id'])) {
                                            // Xử lý lấy thông tin bài viết từ CSDL
                                            $post_id = $_GET['id'];
                                             $sql2 = "SELECT * FROM posts WHERE id ='$post_id'";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                              $name_tk = $row2['username'];
  $sql4 = "SELECT * FROM player WHERE name = '$name_tk'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            $id_tk = $row4['account_id'];
                              $sql5 = "SELECT * FROM account WHERE id = '$id_tk'";
                            $result5 = mysqli_query($conn, $sql5);
                            $row5 = mysqli_fetch_assoc($result5);
                            $avatar_post = $row5['anh_web'];
       if($avatar_post == 0){$avatar_1="avatar/andanh.png";}else{$avatar_1 = $avatar_post;}    
       $date = $row2['created_at'];
                                 $time_diff = $today1 - $date;                                        if ($time_diff < 60) {
                                                    $day_dang = $time_diff . ' phút trước';
                                                } elseif ($time_diff < 3600) {
                                                     $day_dang = floor($time_diff / 60) . ' giờ trước';
                                                } elseif ($time_diff < 86400) {
                                                     $day_dang = floor($time_diff / 3600) . ' ngày trước';
                                                } elseif ($time_diff < 2592000) {
                                                     $day_dang = floor($time_diff / 86400) . ' tháng trước';
                                                } elseif ($time_diff < 31536000) {
                                                     $day_dang = floor($time_diff / 2592000) . ' năm trước';
                                            } 
      $vew = $row2['vew'];                      
$update_query = "UPDATE posts SET vew = ($vew + 1) WHERE id = $post_id";
                                    mysqli_query($conn, $update_query);
if(isset($_POST['comment'])){
$tieude = htmlspecialchars($_POST['comment']);
$sql = "INSERT INTO binh_luan (name,tieude, created_at,id_post) VALUES ('$_name', '$tieude', '$today1', '$post_id')";
            mysqli_query($conn, $sql);
}                                  
                 }                 
?>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn đăng xuất?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Đóng'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Thành công',
                    text: '',
                    icon: 'success',
                    timer: 1000,
                    showConfirmButton: false
                }
                ).then(() => {
                    window.location = 'logout.php'
                });
            }
        })
    }
</script>            <div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">


                <div class="alert alert-danger" style="border-radius: 7px;">
                    <div class="col">
                        <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td width="60px;" style="vertical-align: top">
                                        <div class="text-center" style="margin-left: -10px;">
                                            <img class="avatar" src="<?php echo$avatar_1;?>"
                                                 style="width: 30px; "><br>
                                            <div style="font-size: 9px; padding-top: 5px">
                                                <b class="text-dark"><?php echo $row2['username'];?></b>
                                                <br>
                                                <b style="color: red;"></b>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="bg bg-light" style="border-radius: 7px;">
                                        <div class="row" style="font-size: 9px; padding: 5px 7px;">
                                            <div class="col">
                                                <span><?php echo $day_dang;?></span>
                                            </div>
                                            <div class="col text-right">
                                                <span>lượt xem: <?php echo$row2['vew'];?></span>
                                            </div>
                                        </div>
                                        <div class="row" style="padding: 0 7px 15px 7px">
                                            <div class="col">
                                                <b class="title-topic" style="color:#9100ff;"><?php echo$row2['tieude'];?></b>
                                                <br>
                                                <span><?php echo$row2['noidung'];?></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



  <?php      
  $post_id = $_GET['id'];                                         $sql = "SELECT * FROM binh_luan WHERE id_post ='$post_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()){
  $name_tk = $row['name'];
  $sql4 = "SELECT * FROM player WHERE name = '$name_tk'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            $id_tk = $row4['account_id'];
                              $sql5 = "SELECT * FROM account WHERE id = '$id_tk'";
                            $result5 = mysqli_query($conn, $sql5);
                            $row5 = mysqli_fetch_assoc($result5);
                            $avatar_post = $row5['anh_web'];
       if($avatar_post == 0){$avatar_1="avatar/andanh.png";}else{$avatar_1 = $avatar_post;}  
           $date = $row['created_at'];
                                 $time_diff = $today1 - $date;                                        if ($time_diff < 60) {
                                                    $day_dang = $time_diff . ' phút trước';
                                                } elseif ($time_diff < 3600) {
                                                     $day_dang = floor($time_diff / 60) . ' giờ trước';
                                                } elseif ($time_diff < 86400) {
                                                     $day_dang = floor($time_diff / 3600) . ' ngày trước';
                                                } elseif ($time_diff < 2592000) {
                                                     $day_dang = floor($time_diff / 86400) . ' tháng trước';
                                                } elseif ($time_diff < 31536000) {
                                                     $day_dang = floor($time_diff / 2592000) . ' năm trước';
                                            }     
echo'       <div class="alert alert-danger" style="border-radius: 7px;">                             

                                                    <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
                                <tbody>
                                    <tr>
                                        <td width="60px;" style="vertical-align: top">
                                            <div class="text-center" style="margin-left: -10px;">
                                                <img class="avatar" src="'.$avatar_1.'"
                                                     style="width: 30px; "><br>
                                                <div style="font-size: 9px; padding-top: 5px">
                                                    <b>'.$row['name'].'</b>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="bg bg-white" style="border-radius: 7px;">
                                            <div class="row"
                                                 style="font-size: 9px; padding: 5px 7px;">
                                                <div class="col">
                                                    <span>'.$day_dang.'</span>
                                                </div>
                                                <div class="col text-right">
                                                    <span>Điểm: 0</span>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 0 7px 15px 7px">
                                                <div class="col">
                                                    <span>'.$row['tieude'].'</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                                                </div>';    
                   }         
                        }
                        ?>



                                    <div class="d-flex justify-content-end">
                    <ul class="pagination" style="height:20px;">
                        <a class="btn btn-action text-white" href="topic.php?id=1169&page=-1" aria-label="Previous"
                           style="border-radius: 15px 0px 0px 15px; pointer-events: none;">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                        <li class=""><a class="btn btn-warning text-white" href="topic.php?id=1169&page=0">1</a></li>
                                                <a class="btn btn-action text-white" href="topic.php?id=1169&page=1" aria-label="Next"
                           style="border-radius: 0px 15px 15px 0px; pointer-events: none;">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </ul>
                </div>
                <hr>
                
                                    <!--<hr>-->
                    <div class="col">
                        <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td width="60px;" style="vertical-align: top">
                                        <div class="text-center" style="margin-left: -10px; heigh:35px;">
                                            <img class="avatar" src="<?php if($_anh_web == 0){$avatar="avatar/andanh.png";}else{$avatar = $_anh_web;}echo $avatar;?>"
                                                 width="30px" style="heigh:100%;"><br>
                                        </div>
                                    </td>

                                    <td style="border-radius: 7px;">
                                        <form method="POST">
                                            <div class="row">
                                                <div class="form-group mb-1">
                                                    <textarea class="form-control" name="comment" id="" rows="3"
                                                              placeholder="Bình luận không vượt quá 75 ký tự"  style="border-radius: 7px;" formControlName="content"></textarea>
                                                </div>
                                                <div class="mt-1">
                                                    <button type="submit" name="submit" class="btn btn-action text-white" style="border-radius: 7px;" > <i
                                                            class="fa fa-comment"></i>Bình luận</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                



















            </div>
            <!-- footer -->
<footer class="mt-1">
    
    
    <div class="text-center mt-1">
       <b style="font-size:13px;" class="text-white">Tham gia cộng đồng giao lưu game với chúng tớ.</b>
       <br>
       <a href="" target="_blank"><img src="assets/images/icon/findondiscord.png" style="max-width:100px" class="mt-1"></a>
       <a href="https://www.facebook.com/groups/ngocronghades" target="_blank"><img src="assets/images/icon/findonfb.png" style="max-width:100px" class="mt-1"></a>
   </div>
    <div class="text-center text-white">
        Trò chơi không có bản quyền chính thức, hãy cân nhắc kỹ trước khi tham gia.<br>
        Chơi quá 180 phút một ngày sẽ ảnh hưởng đến sức khỏe.
    </div>
</footer>        </div>
    </body>
</html>