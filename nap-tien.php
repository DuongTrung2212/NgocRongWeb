<?php
include('set.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); //khởi động phiên làm việc
}
include_once 'head.php';
if($_dangnhap == 0) {header("location:/login.php");}
?>
  <div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<link rel="stylesheet" href="https://cdn.rawgit.com/daneden/animate.css/v3.1.0/animate.min.css">
		<script src='https://cdn.rawgit.com/matthieua/WOW/1.0.1/dist/wow.min.js'></script>
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/css/mdb.min.css" /> -->
		<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
		<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	</head>
<style>
    .btn-primary {
        border-color: #f44336 !important;
        color: #fff !important;
    }

    .border-primary {
        border-color: #f44336 !important;
    }

    .bg-primary,
    .btn-primary {
        background-color: #f44336 !important;
    }

    .btn-outline-primary:hover {
        background-color: #f44336;
        border-color: #f44336;
    }

    .btn-outline-primary {
        color: #f44336;
        border-color: #f44336;
    }

    .feature-box {
        padding: 38px 30px;
        position: relative;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 0 29px 0 rgb(18 66 101 / 8%);
        transition: all 0.3s ease-in-out;
        border-radius: 8px;
        z-index: 1;
        width: 100%;
    }

    .feature-icon {
        font-size: 1.8em;
        margin-bottom: 1rem;
    }

    .feature-title {
        font-size: 1.2em;
        font-weight: 500;
        padding-bottom: 0.25rem;
        text-decoration: none;
        color: #212529;
    }

    .list-group-item.active {
        background-color: #007bff;
        border-color: #007bff;
    }

    a {
        text-decoration: none;
    }

    .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
        background-color: #007bff;
    }

    .nav-link {
        color: #007bff;
    }

    .nav-link:focus, .nav-link:hover {
        color: #cd3a2f;
    }

</style>
<main class="flex-grow-1 flex-shrink-1">
<script type="text/javascript"> new WOW().init(); </script>
</br>
    <div class="container py-3">
         <main>    
                <div class="row">
        <div class="col-md-3 pb-3 pt-2">
        <div class="list-group d-none d-sm-block">
                        <a href="profile.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-user me-2"></i> Thông tin tài khoản
                        </a>
                        <a href="nap-tien.php" class="list-group-item list-group-item-action active">
                            <i class="fas fa-coins me-2"></i> Nạp thẻ cào
                        </a>


                        <a href="top-nap.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-credit-card me-2"></i> Top Nạp
                        </a>
                        <a href="/?out" class="list-group-item list-group-item-action ">
                            <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                        </a>

                    </div>
        </div>
                  <div class="col-md-9 pb-3 pt-2">
            <h5>Nạp Thẻ Tự Động</h5>
                        <table class="table">
	<div class="row">
                </div>
                <div class="col-4 text-right">
                </div>
              </div>
            </div>
            <div class="card-body">
                
            <form method="POST" action="#" id="myform">
				     <tbody>
                     <label>Tài Khoản: </label><br>
<input type="text" class="form-control form-control-alternative" style="border-radius: 7px; box-shadow: 0px 0px 5px red"name="username" value="<?php echo $_username; ?>
" readonly required>

						<label>Loại thẻ:</label>
						</br>
						<select style="border-radius: 7px; box-shadow: 0px 0px 5px red" name="card_type" required>
							<option value="">Chọn loại thẻ</option>
							 <?php 
	                    $cdurl = curl_init("https://thesieutoc.net/card_info.php"); 
                       	curl_setopt($cdurl, CURLOPT_FAILONERROR, true); 
	                    curl_setopt($cdurl, CURLOPT_FOLLOWLOCATION, true); 
	                    curl_setopt($cdurl, CURLOPT_RETURNTRANSFER, true); 
						curl_setopt($cdurl,CURLOPT_CAINFO, __DIR__ .'/api/curl-ca-bundle.crt');
						curl_setopt($cdurl,CURLOPT_CAPATH, __DIR__ .'/api/curl-ca-bundle.crt');
	                    $obj = json_decode(curl_exec($cdurl), true); 
	                    curl_close($cdurl);
						$length = count($obj);
						for ($i = 0; $i < $length; $i++) {
							if ($obj[$i]['status'] == 1){
								echo '<option value="'.$obj[$i]['name'].'">'.$obj[$i]['name'].' ('.$obj[$i]['chietkhau'].'%)</option> ';
							}
						}
							?>
						</select>
						</br>
						<label>Mệnh giá:</label>
						<select style="border-radius: 7px; box-shadow: 0px 0px 5px red" class="form-control form-control-alternative" name="card_amount" required>
							<option value="">Chọn mệnh giá</option>
							<option value="10000">10.000</option>
							<option value="20000">20.000</option>
							<option value="30000">30.000 </option>
							<option value="50000">50.000</option>
							<option value="100000">100.000</option>
							<option value="200000">200.000</option>
							<option value="300000">300.000</option>
							<option value="500000">500.000</option>
						    <option value="1000000">1.000.000</option>
						</select>
						<label>Số seri:</label>
						<input style="border-radius: 7px; box-shadow: 0px 0px 5px red" type="text" class="form-control form-control-alternative" name="serial" required />
						<label>Mã thẻ:</label>
						<input style="border-radius: 7px; box-shadow: 0px 0px 5px red" type="text" class="form-control form-control-alternative" name="pin" required /><br>
						<button type="submit" class="btn btn-action text-white" name="submit">NẠP NGAY</button>
					
					</tbody>
				</form>
				<script type="text/javascript">

	
    $("#myform").submit(function(e) {
		$("#status").html("<img src='./assets/load.gif' width='30%' />");
        e.preventDefault();
        $.ajax({
                url: "./ajax/card.php",
                type: 'post',
                data: $("#myform").serialize(),
                success: function(data) {
                   $("#status").html(data);
                   document.getElementById("myform").reset(); 
				   $("#load_hs").load("./ajax/history.php");
                }
        });

    });

 
</script><br><br>
<div>- Hãy Kiểm Tra Kĩ Thông Tin Trước Khi Nạp</div>
<div>- Nạp Sai Mệnh Giá, Thông Tin Thẻ Admin Không Chịu Trách Nhiệm.</div>
<div>- Quá 30 Phút Thẻ Chưa Duyệt Hãy Báo Ngay Cho Admin Để Được Hỗ Trợ Nhanh Nhất!</div>

		</form>
            </div>
          </div>
        </div>
        <div id="status"></div>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
         <!-- Code made in tui 127.0.0.1 -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>	
		</div>
	</main>
