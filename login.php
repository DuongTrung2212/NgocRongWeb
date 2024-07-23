<?php
include('head.php');
$_captcha=rand(1,9); 
$_captcha2=rand(1,9); 
$tong_captcha = $_captcha + $_captcha2;
if($_dangnhap == 1){echo'<script>
							window.location="index.php";
		</script>';}else{
if(isset($_POST['username'])){
$tk = htmlspecialchars($_POST['username']);
$mk = htmlspecialchars($_POST['password']);
$captcha = htmlspecialchars($_POST['captcha']);
if($_POST['submit'] == $captcha){
$sql4 = "SELECT * FROM account WHERE username ='$tk' && password = '$mk'";
                            $result4 = mysqli_query($conn, $sql4);
                            if($row4 = mysqli_fetch_assoc($result4)){
                            $id_tk = $row4['id'];
                            $sql5 = "SELECT * FROM player WHERE account_id ='$id_tk'";
                            $result5 = mysqli_query($conn, $sql5);
                            if($row5 = mysqli_fetch_assoc($result5)){
$_SESSION['username'] = $tk;
$_SESSION['password'] = $tk;
                            echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đăng nhập thành công!!",
								type: "success",
					
						  })
						});	
						function ok() {
							window.location="index.php";
							}
							setInterval(ok, 1000);			
						</script>
						';	
						}else{
						echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Tài khoản chx tạo nhân vật!",
                        type: "warning",
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
                        text: "Thông tin đăng nhập không chính xác!",
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
                        text: "Thông tin captcha k chíng xác!",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
}
}
?>
          <div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
                <form class="text-center col-lg-5 col-md-10" style="margin: auto;"
                      method="post" action="login.php">
                    <h1 class="h3 mb-3 font-weight-normal">Đăng Nhập</h1>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="username"
                           type="text" class="form-control mt-1" placeholder="Tên tài khoản" autofocus="">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="password"
                           type="password" class="form-control mt-1" placeholder="Mật khẩu">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    
                    
                    
                                        <div class="row">
                        <div class="col-7">
                            <input style="height: 50px; border-radius: 15px; font-weight: bold;"
                                   type="text" class="form-control mt-1" name="captcha"
                                   placeholder="kết quả captcha">
                        </div>
                        <div class="col-5">
<?php echo''.$_captcha.'+'.$_captcha2.'';?>
</a>
                        </div>
                    </div>
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <div class="text-center mt-1">
                        <button class="btn btn-lg btn-dark btn-block" style="border-radius: 10px;width: 100%; height: 50px;"
                                type="submit" name="submit" value="<?php echo$tong_captcha;?>">Đăng nhập</button>
                    </div>
                </form>
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
      </footer>     </div>
    </body>
</html>
<?php
}
?>