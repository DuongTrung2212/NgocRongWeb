<?php
include('head.php');
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
</script>            <div class="p-1 pb-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">






                                    <div class="alert alert-danger" style="border-radius: 7px;">
                                                    <div>
                                <div style="width: 55px; float:left; margin-right: 10px;">
                                    <img class="avatar" src="assets/images/avatar/29.png"
                                         style="width: 50px; height: 55px;">
                                </div>
                                <a href="mo-thanh-vien.php"
                                   class="alert-link text-decoration-none font-weight-bold" style="color:#9100ff; font-size:18px;"> 
                           MỞ THÀNH VIÊN 10K                             </a>
                                <div class="box_name_eman">bởi <b>
                                        <b style="color:red">Admin</b>
                                    </b>
                                </div>
                                <br>                            </div>
                                                        <div>
                                <div style="width: 55px; float:left; margin-right: 10px;">
                                    <img class="avatar" src="assets/images/avatar/29.png"
                                         style="width: 50px; height: 55px;">
                                </div>
                                <a href="bxh.php"
                                   class="alert-link text-decoration-none font-weight-bold" style="color:#9100ff; font-size:18px;"> 
                                      BẢNG XẾP HẠNG                                </a>
                                <div class="box_name_eman">bởi <b>
                                        <b style="color:red">Admin</b>
                                    </b>
                                </div>
                                <br>                            </div>
                                                        <div>
                                <div style="width: 55px; float:left; margin-right: 10px;">
                                    <img class="avatar" src="assets/images/avatar/29.png"
                                         style="width: 50px; height: 55px;">
                                </div>
                                <a href="gioi-thieu.php"
                                   class="alert-link text-decoration-none font-weight-bold" style="color:#9100ff; font-size:18px;"> 
                                       GIỚI THIỆU BẠN BÈ NHẬN VND                         </a>
                                <div class="box_name_eman">bởi <b>
                                        <b style="color:red">Admin</b>
                                    </b>
                                </div>
                                <br>                            </div>
                                                        <div>
                                <div style="width: 55px; float:left; margin-right: 10px;">
                                    <img class="avatar" src="assets/images/avatar/29.png"
                                         style="width: 50px; height: 55px;">
                                </div>
                                <a href="xoa-bai-viet.php"
                                   class="alert-link text-decoration-none font-weight-bold" style="color:#9100ff; font-size:18px;"> 
                                       XOÁ BÀI VIẾT <img src='https://www.nrohades.com/assets/images/icon/hot.gif'>                                </a>
                                <div class="box_name_eman">bởi <b>
                                        <b style="color:red">Admin</b>

                                    </b>
                                </div>
                                                            </div>
                                                </div>
                                   
                                   
                                    <div class="alert alert-danger" style="border-radius: 7px;">
                                                    <div>
  <?php                                               $sql = "SELECT * FROM posts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()){
  $name_tk = $row['username'];
  $sql4 = "SELECT * FROM player WHERE name = '$name_tk'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            $id_tk = $row4['account_id'];
                              $sql5 = "SELECT * FROM account WHERE id = '$id_tk'";
                            $result5 = mysqli_query($conn, $sql5);
                            $row5 = mysqli_fetch_assoc($result5);
                            $avatar_post = $row5['anh_web'];
       if($avatar_post == 0){$avatar_1="avatar/andanh.png";}else{$avatar_1 = $avatar_post;}             
                            
  echo'
                                <div style="width: 55px; float:left; margin-right: 10px;">
                                    <img class="avatar" src="'.$avatar_1.'"
                                         style="border-color:red; width: 50px; height: 55px;">
                                </div>
                                <a href="topic.php?id='.$row['id'].'"
                                   class="alert-link text-decoration-none" 
                                   title="'.$row['tieude'].'">
                                 '.$row['tieude'].'                            </a>
                                <div class="box_name_eman">bởi <b>
                                        <b style="color:red">'.$row['username'].'</b>
                                    </b>
                                </div>
                                <br>                     </div>
                                <div>';
}
}
?>
                                    <div class="d-flex justify-content-between">
                                    <?php
                                    if($_dangnhap == 0){
                                    echo '<div> </div>';
                                    }else{
                                    echo'
<div>
                            <a href="post-topic.php" class="btn btn-action text-white" style="border-radius: 7px;" routerLink="post">Đăng bài</a>
                        </div>
                        ';
                        }
                        ?>
                                        <ul class=" pagination">
                        <a class="btn btn-action text-white" href="forum.php?page=-1" aria-label="Previous"
                           style="border-radius: 15px 0px 0px 15px; pointer-events: none;">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                        <li class=""><a class="btn btn-warning text-white" href="forum.php?page=0">1</a></li>
                                                    <li class=""><a class="btn btn-action text-white" href="forum.php?page=1">2</a></li>
                                                    <li class=""><a class="btn btn-action text-white" href="forum.php?page=2">3</a></li>
                                                <a class="btn btn-action text-white" href="forum.php?page=1" aria-label="Next"
                           style="border-radius: 0px 15px 15px 0px; ">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </ul>
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