<?php
include('head.php');
$today1 = date("YmdHi");
if($_dangnhap == 0){echo'<script>
							window.location="login.php";
		</script>';
}
if(isset($_POST['content'])){
$tieude = htmlspecialchars($_POST['title']);
$noidung = htmlspecialchars($_POST['content']);
$sql = "INSERT INTO posts (username,tieude, noidung, created_at) VALUES ('$_name', '$tieude', '$noidung', '$today1')";
            mysqli_query($conn, $sql);
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
</script>            <div class="p-1 mt-1 alert alert-info" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">




                <div class="alert alert-danger" style="border-radius: 7px;">
                    <form method="POST" action="post-topic.php">
                        <b>Tiêu đề</b>
                        <input type="text" class=" form-control" style="border-radius: 7px;" placeholder="Tiêu đề (không quá 75 ký tự)"
                               required="" autofocus="" name="title">
                        <br>
                        <b>Nội dung</b>
                        <textarea class="form-control" style="border-radius: 7px;" name="content" id="" cols="30" rows="10"
                                  placeholder="Nội dung (không được quá 256 ký tự)"></textarea>

                        <!--                        <div class="row">
                                                    <div class="form-group col-3 mt-1">
                                                        <input type="text" class="form-control" name="captcha"
                                                               style="width: 100%; height: 45px;border-radius: 7px;" placeholder=" Nhập captcha"
                                                               formControlName="captcha">
                                                    </div>
                                                    <div class="form-group col-3 mt-1">
                                                        <img [src]="imageCaptcha" alt="Captcha" style="width: 100%; height: 45px; border-radius: 7px;">
                                                    </div>
                                                    <div class="form-group col-1 mt-1 text-center">
                                                        <button (click)="recaptcha()" style="width:100%;border-radius: 15px;" class="btn btn-danger">
                                                            &#10226;</button>
                                                    </div>
                                                </div>-->


                        <button class="btn btn-action text-white m-1" name="submit" type="submit" style="border-radius: 7px;">Đăng bài</button>
                    </form>
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