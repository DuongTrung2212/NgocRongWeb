<?php 
include'head.php';
include'luu.php';
if($_dangnhap == 0){echo'<script>
							window.location="login.php";
		</script>';}
		if($_is_admin == 0){
		echo'<script>
							window.location="/";
		</script>';
		}else{
?>

<?php
if(isset($_POST['pc'])){
$apk = $_POST['apk'];
$pc = $_POST['pc'];
$ios = $_POST['ios'];
$ios2 = $_POST['ios2'];
$zalo = $_POST['zalo'];
$fp = fopen("luu.php", "w");//mở file ở chế độ write-only
fwrite($fp, "<?php
\$apk = \"$apk\";
\$pc = \"$pc\";
\$ios = \"$ios\";
\$ios2 = \"$ios2\";
\$zalo = \"$zalo\";
?>

");
fclose($fp); 
}
?>
<div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
<form class="text-center col-lg-5 col-md-10" style="margin: auto;"
                      method="post">
                    <h1 class="h3 mb-3 font-weight-normal">Admin Kuroko</h1>
                    <label> pc</label>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="pc" required="" autofocus="" value="<?php echo$pc;?>"
                           type="text" class="form-control mt-1" placeholder="pc">
                           
                           <label> apk</label>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="apk" required="" autofocus="" value="<?php echo$apk;?>"
                           type="text" class="form-control mt-1" placeholder="apk">
                           <label> ios</label>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="ios" required="" autofocus="" value="<?php echo$ios;?>"
                           type="text" class="form-control mt-1" placeholder="ios">
                           <label> ios teafing</label>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="ios2" required="" autofocus="" value="<?php echo$ios2;?>"
                           type="text" class="form-control mt-1" placeholder="ios teafing">
                           <label> box zalo</label>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="zalo" required="" autofocus="" value="<?php echo$zalo;?>"
                           type="text" class="form-control mt-1" placeholder="zalo">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                                        <button class="btn btn-lg btn-dark btn-block" style="border-radius: 10px;width: 100%; height: 50px;"
                                type="submit" name="submit">Xác Nhận</button>
                    </div>
                </form>
<?php
}
?>