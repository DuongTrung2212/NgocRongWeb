<?php
include('head.php');
$_captcha=rand(1,9); 
$_captcha2=rand(1,9); 
$tong_captcha = $_captcha + $_captcha2;
if($_dangnhap == 0){echo'<script>
							window.location="login.php"</script>'; }else{
if(isset($_POST['oldpassword'])){
$mk = htmlspecialchars($_POST['oldpassword']);
$mk_new = htmlspecialchars($_POST['password']);
$mk_new1 = htmlspecialchars($_POST['repassword']);
$captcha = htmlspecialchars($_POST['captcha']);
if($captcha == $_POST['submit']){
$sql1 = "SELECT * FROM account WHERE username  ='$_tk' && password = '$mk'";
                            $result1 = mysqli_query($conn, $sql1);
                           if($row1 = mysqli_fetch_assoc($result1)){
                           if($mk_new == $mk_new1){
                           $update_query = "UPDATE account SET 
 password = '$mk_new'
 WHERE username = '$_tk'";
 mysqli_query($conn, $update_query);
                              echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đổi mật khẩu mới thành công!!",
								type: "success",
								confirmButtonText: "OK",
						  })
						});
						
						</script>
						';
                           }else{
                           echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Hai mật khẩu mới không giống nhau!",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
                           }
                            }else{
                            echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Mật khẩu cũ không chính xác!",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
                            }
}else{
echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Captcha Sai!",
                        type: "warning",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
}
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
                    window.location = 'out.php'
                });
            }
        })
    }
</script>           <div style="background: #ffe8d1; border-radius: 7px; box-shadow: 0px 2px 5px black;" class="pb-1">
                <form class="text-center col-lg-5 col-md-10" style="margin: auto;"
                      method="post" action="change-password.php">
                    <h1 class="h3 mb-3 font-weight-normal">Đổi mật khẩu</h1>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="oldpassword" required="" autofocus=""
                           type="password" class="form-control mt-1" placeholder="Mật khẩu cũ">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="password" required=""
                           type="password" class="form-control mt-1" placeholder="Mật khẩu mới">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="repassword" required=""
                           type="password" class="form-control mt-1" placeholder="Nhập lại mật khẩu">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <div class="row">
                        <div class="col-7">
                            <input style="height: 50px; border-radius: 15px; font-weight: bold;"
                                   type="text" class="form-control mt-1" name="captcha"
                                   placeholder="Nhập captcha">
                        </div>
                        <div class="col-5">
                       <?php echo''.$_captcha.'+'.$_captcha2.'';?>
                        </div>
                    </div>
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <div class="text-center mt-1">
                        <button class="btn btn-lg btn-dark btn-block" style="border-radius: 10px;width: 100%; height: 50px;"
                                type="submit" name="submit" value="<?php echo$tong_captcha;?>">Đổi mật khẩu</button>
                    </div>
                
                
            </div>
            <!-- footer -->
            <footer class="mt-1">
        <br>
        <div class="text-center text-black">
          <script>
            function getYear() {
              var date = new Date();
              var year = date.getFullYear();
              document.getElementById("currentYear").innerHTML = year;
            }
          </script>
          
            <small>
              <b>NGỌC RỒNG KUROKO</b>
            </small>
            <br>
            <small>
              <span id="currentYear">2024</span> © Được Vận Hành Bởi <b>
                <u>Nro Kuroko</u>
              </b>
            </small>
          
        </div>
      </footer>    </div>
    </body>
</html>
