<?php
include'head.php';
if(isset($_POST['api'])){
$api_new = $_POST['api'];
$fp = fopen("api/config.php", "w");//mở file ở chế độ write-only
fwrite($fp, "<?php
	\$apikey = '$api_new'; //API key, lấy từ website thesieutoc.net thay vào trong cặp dấu ''
	// database Mysql config
	\$local_db = \"$ip_sv\";
	\$user_db = \"$user_sv\";
	\$pass_db = \"$pass_sv\";
	\$name_db = \"$dbname_sv\";
	# đừng đụng vào 
  \$conn = new mysqli(\$local_db, \$user_db, \$pass_db, \$name_db);
  \$conn->set_charset(\"utf8\");
    
?>
");
fclose($fp); 
}
?>
<div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
<form class="text-center col-lg-5 col-md-10" style="margin: auto;"
                      method="post">
                    <h1 class="h3 mb-3 font-weight-normal">Api mới</h1>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="api" required="" autofocus=""
                           type="text" class="form-control mt-1" placeholder="Api Mới">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                                        <button class="btn btn-lg btn-dark btn-block" style="border-radius: 10px;width: 100%; height: 50px;"
                                type="submit" name="submit">Xác Nhận</button>
                    </div>
                </form>