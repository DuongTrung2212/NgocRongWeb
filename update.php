<html lang="en">
  <head> 
<meta charset="utf-8">
<title>Ngọc Rồng Kuroko</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="assets/images/icon/icon.ico">


<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
crossorigin="anonymous"></script>
<!-- icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<!-- mycss -->
<link rel="stylesheet" href="/css/mystyle.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- myjs -->
<!--<script src="js/tet.js"></script>-->

<!-- bootstrap -->
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
crossorigin="anonymous"></script> 
<script>
		var login = false
		var stop, staticx;
		var img = new Image();
		img.src = "../image/21623.png";

		function Sakura(x, y, s, r, fn) {
			this.x = x;
			this.y = y;
			this.s = s;
			this.r = r;
			this.fn = fn;
		}

		Sakura.prototype.draw = function (cxt) {
			cxt.save();
			var xc = 40 * this.s / 4;
			cxt.translate(this.x, this.y);
			cxt.rotate(this.r);
			cxt.drawImage(img, 0, 0, 50 * this.s, 50 * this.s)
			cxt.restore();
		}

		Sakura.prototype.update = function () {
			this.x = this.fn.x(this.x, this.y);
			this.y = this.fn.y(this.y, this.y);
			this.r = this.fn.r(this.r);
			if (this.x > window.innerWidth ||
				this.x < 0 ||
				this.y > window.innerHeight ||
				this.y < 0
			) {
				this.r = getRandom('fnr');
				if (Math.random() > 0.4) {
					this.x = getRandom('x');
					this.y = 0;
					this.s = getRandom('s');
					this.r = getRandom('r');
				} else {
					this.x = window.innerWidth;
					this.y = getRandom('y');
					this.s = getRandom('s');
					this.r = getRandom('r');
				}
			}
		}

		SakuraList = function () {
			this.list = [];
		}
		SakuraList.prototype.push = function (sakura) {
			this.list.push(sakura);
		}
		SakuraList.prototype.update = function () {
			for (var i = 0, len = this.list.length; i < len; i++) {
				this.list[i].update();
			}
		}
		SakuraList.prototype.draw = function (cxt) {
			for (var i = 0, len = this.list.length; i < len; i++) {
				this.list[i].draw(cxt);
			}
		}
		SakuraList.prototype.get = function (i) {
			return this.list[i];
		}
		SakuraList.prototype.size = function () {
			return this.list.length;
		}

		function getRandom(option) {
			var ret, random;
			switch (option) {
				case 'x':
					ret = Math.random() * window.innerWidth;
					break;
				case 'y':
					ret = Math.random() * window.innerHeight;
					break;
				case 's':
					ret = Math.random();
					break;
				case 'r':
					ret = Math.random() * 5;
					break;
				case 'fnx':
					random = -0.5 + Math.random() * 1;
					ret = function (x, y) {
						return x + 0.5 * random - 1;
					};
					break;
				case 'fny':
					random = 0.5 + Math.random() * 0.5
					ret = function (x, y) {
						return y + random;
					};
					break;
				case 'fnr':
					random = Math.random() * 0.01;
					ret = function (r) {
						return r + random;
					};
					break;
			}
			return ret;
		}

		function startSakura() {

			requestAnimationFrame = window.requestAnimationFrame ||
				window.mozRequestAnimationFrame ||
				window.webkitRequestAnimationFrame ||
				window.msRequestAnimationFrame ||
				window.oRequestAnimationFrame;
			var canvas = document.createElement('canvas'),
				cxt;
			staticx = true;
			canvas.height = window.innerHeight;
			canvas.width = window.innerWidth;
			canvas.setAttribute('style', 'position: fixed;left: 0;top: 0;pointer-events: none;');
			canvas.setAttribute('id', 'canvas_sakura');
			document.getElementsByTagName('body')[0].appendChild(canvas);
			cxt = canvas.getContext('2d');
			var sakuraList = new SakuraList();
			for (var i = 0; i < 50; i++) {
				var sakura, randomX, randomY, randomS, randomR, randomFnx, randomFny;
				randomX = getRandom('x');
				randomY = getRandom('y');
				randomR = getRandom('r');
				randomS = getRandom('s');
				randomFnx = getRandom('fnx');
				randomFny = getRandom('fny');
				randomFnR = getRandom('fnr');
				sakura = new Sakura(randomX, randomY, randomS, randomR, {
					x: randomFnx,
					y: randomFny,
					r: randomFnR
				});
				sakura.draw(cxt);
				sakuraList.push(sakura);
			}
			stop = requestAnimationFrame(function () {
				cxt.clearRect(0, 0, canvas.width, canvas.height);
				sakuraList.update();
				sakuraList.draw(cxt);
				stop = requestAnimationFrame(arguments.callee);
			})
		}

		window.onresize = function () {
			var canvasSnow = document.getElementById('canvas_snow');
			canvasSnow.width = window.innerWidth;
			canvasSnow.height = window.innerHeight;
		}

		img.onload = function () {
			startSakura();
		}

		function stopp() {
			if (staticx) {
				var child = document.getElementById("canvas_sakura");
				child.parentNode.removeChild(child);
				window.cancelAnimationFrame(stop);
				staticx = false;
			} else {
				startSakura();
			}
		}
	</script>
  <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && event.key === 'I')) {
                document.body.innerHTML = '<h1>Nạp Vào Mà Chơi Bug Cái Con Cặc Địt Mẹ Mày</h1>';
                event.preventDefault();
            }
        });

        document.addEventListener('contextmenu', function(event) {
            document.body.innerHTML = '<h1>Nạp Vào Mà Chơi Bug Cái Con Cặc Địt Mẹ Mày</h1>';
            event.preventDefault();
        });

        setInterval(blockDevTools, 1000);
    </script>
</head>

<body class="girlkun-bg" id="hoangvietdung">
  <div class="container-md p-1 col-sm-12 col-lg-6"
    style="background: #FF99CC; border-radius: 7px; border: 1px solid #FFFFFF; box-shadow: 0 0 15px #66FFFF;">
    <!--màu backrao-->
    <style>
      #snow {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: -70;
      }
    </style>
    <div id="snow"><canvas class="particles-js-canvas-el" width="1365" height="953" style="width: 100%; height: 100%;"></canvas></div>
    <style>
    #snow {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: -100;
    }

</style>

<div id="snow"></div>

    <main>
      <!-- header -->
      <div style="background: #FFCCCC; border-radius: 7px; box-shadow: 0px 2px 5px black;" class="pb-1">
        <!--nền logo-->
        <!-- logo -->
        <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;"
          class="text-center">
          <img height="12" src="../image/12.png" style="vertical-align: middle;">
          <span class="text-black" style="vertical-align: middle;">Dành cho người chơi trên 12 tuổi. Chơi quá 180 phút
            mỗi ngày sẽ có hại sức khỏe.</span>
        </div>
        <div class="p-xs">
          <a href="/">
            <img src="../image/logogif.gif"
              style="display: block;margin-left: auto;margin-right: auto;max-width: 350px;">
          </a>
        </div>
        <!-- download -->
        <div class="text-center mt-2">
          <br>

          <div style="display: flex; justify-content: center; align-items: center; gap: 25px; margin-bottom: 10;">
              <a href="../taive/Nro Kuroko.apk" style="border-radius: 20px; width: 100px; text-decoration: none;">
                <img src="../image/apk.png" style="max-width: 120px; display: block; margin: auto;">
              </a>

              <a href="../taive/Nro Kuroko.rar" style="border-radius: 20px; width: 100px; text-decoration: none;">
                <img src="../image/pc.png" style="max-width: 120px; display: block; margin: auto;">
              </a>

              <a href="#" onclick="showModSelection(event, 'IOS', 'https://testflight.apple.com/join/Z9mxrDLN', './taive/NRGo.ipa');" style="border-radius: 20px; width: 100px; text-decoration: none;">
                <img src="../image/ios.png" style="max-width: 120px; display: block; margin: auto;">
              </a>
            </div>
            <!--zalo+face+bxh-->
            <div style="display: flex; justify-content: center; align-items: center; gap: 0px; margin-bottom: 0px;">
            <a href="https://zalo.me/g/apwcti520" style="border-radius: 120px; width: 120px; text-decoration: none;">
                <img src="../image/zalo.png" style="max-width: 120px; display: block; margin: auto;">
              </a>

              <a href="https://www.facebook.com/bkt20102003" style="border-radius: 20px; width: 125px; text-decoration: none;">
                <img src="../image/face.png" style="max-width: 120px; display: block; margin: auto;">
              </a>

              <a href="../bxh.php" style="border-radius: 20px; width: 125px; text-decoration: none;">
                <img src="../image/bxh.png" style="max-width: 120px; display: block; margin: auto;">
              </a>
            </div>

          <span style="color: #2C2254" style="vertical-align: middle;"><b>VUI LÒNG ĐĂNG NHẬP ĐỂ TẢI PHIÊN BẢN GAME THEO
              SERVER NHÉ</b></span></br>
          <span style="color: #2C2254" style="vertical-align: middle;">Tải phiên bản phù hợp để có trải nghiệm
            tốt.</span>

        </div>
      </div>
        <!--body-->
        <div class="col text-center mt-2">
        <div class="user_name">
        <a href="/login.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
          <i class="fa fa-sign-in"></i> Đăng nhập </a>
        <a href="/register.php" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
          <i class="fa fa-user-plus"></i> Đăng ký </a>
        <a href="/forum" class="btn btn-action m-1 text-white" style="border-radius: 10px;">
          <i class="fa fa-group"></i> Diễn Đàn </a>
      </div>
            <div id="myModal" class="modal-body" style="display: none;">
        <p style="padding: 10px">
          <b style="color: red; text-align: center;">PHIÊN BẢN ANDROID: </b><br>
          <b style="color: blue;">- Phiên bản Android hiện tại đã có 2 Phiên Bản!!!!</b>
        </p>
        <center><small><b>Chi tiết xem tại thêm bên dưới.</b><br></small></center>
        <div style="display: flex; justify-content: center; gap: 10px;">
          <a href="javascript:void(0);" class="modalTrigger" data-version="Mod_APK_01" style="border-radius: 20px; width: 100px; text-decoration: none;">
            <img src="../an_remake/logo_game/apk.png" style="max-width: 120px; display: block; margin: auto;">
            <p style="margin-top: -10px; color: #2C2254; font-weight: bold;">Mod_APK_01</p>
          </a>
          <a href="javascript:void(0);" class="modalTrigger" data-version="Mod_APK_02" style="border-radius: 20px; width: 100px; text-decoration: none;">
            <img src="../an_remake/logo_game/apk.png" style="max-width: 120px; display: block; margin: auto;">
            <p style="margin-top: -10px; color: #2C2254; font-weight: bold;">Mod_APK_02</p>
          </a>
        </div>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const triggers = document.querySelectorAll('.modalTrigger');
          const modal = document.getElementById('myModal');
          const closeModalBtn = modal.querySelector('.modalClose');

          triggers.forEach(function (trigger) {
            trigger.addEventListener('click', function () {
              modal.style.display = 'block';
            });
          });
          closeModalBtn.addEventListener('click', function () {
            modal.style.display = 'none';
          });

          window.addEventListener('click', function (event) {
            if (event.target === modal) {
              modal.style.display = 'none';
            }
          });
        });
      </script>
<div class="alert alert-warning" style="background-color: #FFCCCC;">
    <!--màu chi tiết sv-->
    <div class="text-center mb-1">
        <small class=""><b>Thông báo Big update ngày 26 tháng 05 !! </b></small>
        <br>
        <br>
    </div>
    <div class="col">
        <div class="text text-dark text-left mt-2">
            <h4 class="ml-2 text-left"> Chi Tiết Update</h4>
        </div>
        <hr>
    </div>
    <div class="text text-dark p-2">
        <p style="">
        </p>
        <div class="">
            <b style="color:blue">Server ngọc rồng Kuroko được update như sau : </b><br>
                <p><b style="color:red"> </b></p><div><b style="color:red"><b> Theo dõi <a style="color:blue" class="alert-link" href="https://www.facebook.com/tuanpe.ngocronggo/" title=""> Fanpage </a> và web : ngocronggo.com để được nhận thông tin sớm nhất🎊</b> 
                  <!--<b>•🐉️🎊____NPC_HÙNG_VƯƠNG________:Sẽ có mặt tại làn Aru trái đất  🐉️🎊.-->
                  <!--</br>+ 🐉️🎊Làm bánh chưng , bánh tét ngày tết tại lò chế tạo 🐉️🎊-->
                  <!--</br>+ 🐉️🎊Ra mắt thêm chức năng đập đồ thiên tử và đập đồ ảo hóa tại máp đảo kame  🐉️🎊-->
                  <br> 👉 Hóng event game và nhận C.o.ᴅ.ᴇ tại:  <a style="color:black" class="alert-link" href="https://www.facebook.com/tuanpe.ngocronggo/" title=""> Fanpage </a></b></div>
                  
                        
                    <br>
                <p><strong>1. Sau 20h00 ngày 26 tháng 05 : !</strong></p>
                <p>• -&gt; Tính năng đổi điểm sang thỏi vàng của sự kiện bắt bọ sẽ đóng lại để tiến hành tổng kết top sự kiện
                </p><p><strong>2. Thêm đệ tử mới Super Broly SSJ4 với chỉ số chi tiết : </strong></p>
                <p>• -&gt; 80% Sức đánh + 80% HP + 80% KI
                </p><p><strong>3. Update bản đồ mới ( Map Vũ Trụ Huỷ Diệt ) và thêm Boss Huỷ diệt </strong></p>
                <p>• -&gt; Vào map bằng cách sử dụng nhẫn Vũ Trụ ( có thể sở hữu khi diệt Black hoặc mua tại NPC NR Go Bank )
                <br>• -&gt; Giờ đây boss Ba con sói sẽ xuất hiện tại map huỷ diệt ( thay vì tương lai ) và phần thưởng sẽ cao hơn
                <br>• -&gt; Boss Thần Huỷ Diệt và Thiên Sứ sẽ giáng lâm với sức mạnh huỷ diệt ( boss có độ khó cao có tỉ lệ rơi trang bị huỷ diệt và ngọc rồng 1sao )
                </p><p><strong>4. Thêm nhiệm vụ mới ( Nhiệm vụ thức tỉnh bản năng vô cực ) với phần thưởng 2000 thỏi vàng : </strong></p>
                <p>• -&gt; Đây là nhiệm vụ cao nhất cũng như độ khó cực cao và phần thưởng xứng đáng
                <br>• -&gt; Chi tiết nhiệm vụ sẽ hiển thị khi hoàn thành nhiệm vụ tìm vật phẩm tại tương lai</p>
                <!--<p>• -> Giờ đây boss Ba con sói sẽ xuất hiện tại map huỷ diệt ( thay vì tương lai ) và phần thưởng sẽ cao hơn-->
                <!--<p>• -> Giờ đây boss Ba con sói sẽ xuất hiện tại map huỷ diệt ( thay vì tương lai ) và phần thưởng sẽ cao hơn-->
                
        <!--<div class="text text-dark text-left mt-2">-->
        <!--    <h4 class="ml-2 text-left">Đặc điểm nổi bật</h4>-->
        <!--    	<p><img src="../an_remake/sukien/sk_hungvuong_1.png" style="max-width:100%"></p>-->
        <!--</div>-->
        
        
                <!--<strong><p>•2 : Dâng lễ vật đua top sự kiện : </strong></p>-->
                <!--<p>• -> Các vật phẩm như : Dưa Hấu , Bánh Chung , Bánh Tét , Thỏi vàng <=> Có thể dâng lên cho vua hùng để được số điểm nhất định !-->
                <!--</br>• -> Ngoài ra có thể hối lộ hùng vương một cách trắng trợn ^^ !-->
                <!--</br>- Khi sử dụng rada dò, củi có thể mua tại NPC Happy New Year Farm ở các map có mộc nhân, sẽ ra củi đốt.-->
                <!--</br>- Khi săn boss siêu trộm hoặc khi người khác dẫn lân đi dạo giết chết lân, sẽ rơi ra bình nước.-->
                
        <!--<div class="text text-dark text-left mt-2">-->
        <!--    <h4 class="ml-2 text-left">Đặc điểm nổi bật</h4>-->
        <!--    	<p><img src="../an_remake/sukien/sk_hungvuong_2.png" style="max-width:100%"></p>-->
        <!--</div>-->
        <!--</div>-->
        
                <!--<strong><p>•3 : Đổi Dưa Hấu , Bánh Chưng , Bánh Tét </strong></p>-->
                <!--<p>• -> Để đổi dưa hấu cần : x10 Ngà Voi , x10 Cựa Gà , x10 Bờm Ngựa !-->
                <!--</br>• -> Để đổi bánh chưng cần : x99 lá dong , x99 thúng gạo nếp , x99 đậu xanh , x99 xúc xính , x2 dây lạt !-->
                <!--</br>• -> Để đổi dưa bánh tét : x99 lá dong , x99 thúng gạo nếp , x99 đậu xanh , x99 xúc xính , x1 dây lạt !-->
                
        <!--<div class="text text-dark text-left mt-2">-->
        <!--    <h4 class="ml-2 text-left">Đặc điểm nổi bật</h4>-->
        <!--    	<p><img src="../an_remake/sukien/sk_hungvuong_3.png" style="max-width:100%"></p>-->
        <!--</div>-->
        <!--</div>-->
        
                <!--</br>- Khi đã có vật phẩm hãy đem trao cho NPC Happy New Year để tích điểm nhận quà. -->
                <!--</br>+ Thời gian chế tác là 15 phút, sau 15 phút chờ đợi sẽ được làm, và 45 phút sau sẽ nhận được Vật Phẩm-->
                <!--<strong><p>• Top 4 đến 10 : </strong></p>-->
                <!--<p>• -> Sẽ nhận được 200.000 VNĐ vào TK game khi open !-->
                <!--</br>+ Khi lân bị chết trong quá trình dạo chơi, sẽ rơi ra Bình Nước và các phần thưởng khác.-->
                <!--</p>-->
                <!--<p><strong>_______Quà Top Sức Mạnh________: !</strong></p>-->
                <!--   <p>-->
                
               <!--<p><strong>• Top 1: </strong></p>-->
                <!--<p><strong> # Part 1 : Truy Tìm Phong Bao LiXi 💵 </strong></p>-->
                <!--<p>• -> Sẽ nhận được 1.000.000 VNĐ vào TK game khi open !-->
                <!--<strong><p>• Top 2: </strong></p>-->
                <!--<p>• -> Sẽ nhận được 500.000 VNĐ vào TK game khi open !-->
                <!--</br>•Ngoài ra, có hai vật phẩm: Củi đốt và Nước:-->
                <!--</br>- Khi sử dụng rada dò, củi có thể mua tại NPC Happy New Year Farm ở các map có mộc nhân, sẽ ra củi đốt.-->
                <!--</br>- Khi săn boss siêu trộm hoặc khi người khác dẫn lân đi dạo giết chết lân, sẽ rơi ra bình nước.-->
                <!--<strong><p>• Top 3: </strong></p>-->
                <!--<p>• -> Sẽ nhận được 200.000 VNĐ vào TK game khi open !-->
                <!--</br>+ Thời gian chế tác là 15 phút, sau 15 phút chờ đợi sẽ được làm, và 45 phút sau sẽ nhận được Vật Phẩm-->
                <!--</br>+ Khi Chế Tác đã xong các thành viên phải lấy vật phẩm trong vòng 5 phút, nếu không vật phẩm Chế Tác sẽ mất -->
                <!--</br>- Khi đã có vật phẩm hãy đem trao cho NPC Happy New Year để tích điểm nhận quà. -->
                <!--</br>+ Thời gian chế tác là 15 phút, sau 15 phút chờ đợi sẽ được làm, và 45 phút sau sẽ nhận được Vật Phẩm-->
                <!--<strong><p>• Top 4 đến 10 : </strong></p>-->
                <!--<p>• -> Sẽ nhận được 100.000 VNĐ vào TK game khi open !-->
                <!--</br>+ Khi lân bị chết trong quá trình dạo chơi, sẽ rơi ra Bình Nước và các phần thưởng khác.-->
                <!--</p>-->

                <style>
                .highlight {
                 font-weight: bold;
                 color: orange;
                 animation: blink 1s ease-in-out infinite alternate;
                  }
                .highlight2 {
                 font-weight: bold;
                 color: blue;
                 animation: blink 0.3s ease-in-out infinite alternate;
                  }
                .highlight3 {
                 font-weight: bold;
                 color: red;
                 animation: blink 0.1s ease-in-out infinite alternate;
                  }
                @keyframes blink {
                50% { opacity: 1; }
                100% { opacity: 0; }
                }
                </style>
                <!--- <span class="highlight3">*</span> Ngoài ra đánh boss sẽ rớt VPSK là CỦI ĐỐT và NƯỚC CHẾ TÁC, Ngọc rồng 3s... </br>-->
                <!--- <span class="highlight3">*</span> Tổng hợp VPSK: Nước Trưng Cất ; Đường Phèn ; Phẩm Màu ; Túi Bột Noel ; Tất,Vớ Giáng Sinh ; Củi Đốt ; Nước Chế Tác !</br>-->
                <!--- <span class="highlight3">+</span>Nước Trưng Cất ; Đường Phèn ; Phẩm Màu ; Túi Bột Noel ; Tất,Vớ Giáng Sinh ; Củi Đốt ; Nước Chế Tác.</br>-->
                <!--- <span class="highlight3">Cày</span> Item sự kiện cần mua VỢT LƯỚI tại Npc Fide ở đảo kame nhé!</br>-->
                <!--- Ngoài Ra Khi Đủ Mạnh Mọi Người Up Bên Tương Lai Hoặc Cold sẽ rớt rất nhiều đồ bậc cao, bán đồ đi sẽ đc rất nhiều vàng,</br>-->
                <!--* -->
                <!-- <p><strong>3. Săn Boss:</strong></p>-->
                <!--   <p>-->
                <!--<span class="highlight2">~> Khung giờ hỗ trợ nhiệm vụ : 21-22h tối hàng ngày</span></br>-->
                <!--• Tên boss : Kuku, Mập Đầu Đinh, Rambo ( sẽ nhận đc ngọc và nguyên liệu nâng sao , Ngọc Rồng  )</br>-->
                <!--Tiểu đội sát thủ, Fide Đại Ca, Apk 13.14.15, Apk 19.20, Píc Póc Kingkong, Xên Bọ Hung, Xên Hoàn Thiện ( mảnh đồ thần linh và nguyên liệu nâng cấp, Ngọc Rồng )</br>-->
                <!--Siêu Bọ Hung, Xên Con, Cooler, Black Goku ( Vật phẩm nhiệm vụ mảnh đồ thần linh ngọc liệu nâng cấp , Ngọc Rồng )</br>-->
                <!--Và Còn Rất Nhiều Boss Mời AE Vào Game Trải Nghiệm Cùng Mình Nhé</br>-->
                ❤️ Chuẩn bị hành trang cho mình và sẵn sàng chiến game để nhận những phần quà hấp dẫn 😍<br>
                ❤️ ️Chú AE Chơi Game Vui Vẻ 😍<p></p>
            
        </div>

        <div class="text text-dark text-left mt-2">
            <h4 class="ml-2 text-left">Đặc điểm nổi bật</h4>
            	<p><img src="../image/banner.gif" style="max-width:100%"></p>
        </div>
        <div class="text text-dark text-left" style="padding: 20px">
           
            <p></p>
        </div>









        <div class="modal right fade" id="Noti_Home" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
                <div class="modal-dialog modal-side modal-bottom-right">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #FFCCCC; color: #FFF; text-align: center;">
                      <img src="../image/logogif.gif"
                        style="display: block; margin-left: auto; margin-right: auto; max-width: 250px;">
                    </div>
                    <div class="modal-body">
                      <p style="padding: 10px">
                        <b style="color: red; text-align: center;">THÔNG BÁO: </b><br />
                        <b style="color: blue;">- Phiên bản IOS hiện tại đã có mặt trên nền tảng TestFlight
                          !!!!</b><br />
                        <b style="color: blue;">- Chính thức khai mở sever Ngọc Rồng Kuroko !!!!</b><br />
                        <b style="color: blue;">- Hàng Tuần Update sự kiện Tại NPC Cu-Shin, các sự kiện quanh đảo đảo
                          kame và các làng !!!!</b><br />
                        <b>- Cơ chế SKH nâng từng bậc</b>
                        <small>
                          <center>
                            <b>Chi tiết xem tại thêm bên dưới.</b><br />
                          </center>
                        </small>
                      </p>
                      <div style="display: flex; justify-content: center; gap: 10px;">
                        <a href="https://zalo.me/g/apwcti520" target="_blank"
                          style="border-radius: 20px; width: 125px; text-decoration: none; display: inline-block;">
                          <img src="../image/zalo.png"
                            style="max-width: 120px; display: block; margin: auto;">
                        </a>
                        <a href="https://www.facebook.com/tuanpe.ngocronggo/" target="_blank"
                          style="border-radius: 20px; width: 125px; text-decoration: none; display: inline-block;">
                          <img src="../image/face.png"
                            style="max-width: 120px; display: block; margin: auto;">
                        </a>
                      </div>
                      <div class="modal-footer">
                        <b>Thân ái,
                          <span style="color: purple;">Admin !</span>
                          <!--<img src="images/3.png" width="65" height="35" />-->
                          <span style="color: red;"><i class="fa fa-heart" aria-hidden="true"></i></span>
                        </b>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#Noti_Home').modal('show');
    })
</script>
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
      </footer>
    </div>
  		
</main></div></body></html>