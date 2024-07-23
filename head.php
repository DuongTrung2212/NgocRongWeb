<?php
include('set.php');
include('luu.php');
if($_dangnhap == 0){
?><html lang="en">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js';
        script.onload = function () {
            particlesJS("snow", {
                "particles": {
                    "number": {
                        "value": 75,
                        "density": {
                            "enable": true,
                            "value_area": 400
                        }
                    },
                    "color": {
                        "value": "#d3077d"
                    },
                    "opacity": {
                        "value": 1,
                        "random": true,
                        "anim": {
                            "enable": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true
                        }
                    },
                    "line_linked": {
                        "enable": true
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "top",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 300,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "events": {
                        "onhover": {
                            "enable": false
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": false
                    }
                },
                "retina_detect": true
            });
        }
        document.head.append(script);
    });

</script>


<div style="background: #FFCCCC; border-radius: 7px; box-shadow: 0px 2px 5px black;" class="pb-1">
        <!--nền logo-->
        <!-- logo -->
        <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;" class="text-center">
          <img height="12" src="../an_remake/images/icon/12.png" style="vertical-align: middle;">
          <span class="text-black" style="vertical-align: middle;">Dành cho người chơi trên 12 tuổi. Chơi quá 180 phút
            mỗi ngày sẽ có hại sức khỏe.</span>
        </div>
        <div class="p-xs">
          <a href="/">
            <img src="../image/logogif.gif" style="display: block;margin-left: auto;margin-right: auto;max-width: 350px;">
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
            
            <span style="color: #2C2254"><b>VUI LÒNG ĐĂNG NHẬP ĐỂ TẢI PHIÊN BẢN GAME THEO
                SERVER NHÉ</b></span><br>
            <span style="color: #2C2254">Tải phiên bản phù hợp để có trải nghiệm
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
<?php
}else{
?>
<html lang="en">
    <head>
        
<meta charset="utf-8">
<title>Ngọc Rồng Kuroko</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="assets/images/icon/icon.ico">


<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
<link rel="stylesheet" href="css/mystyle.css">
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
crossorigin="anonymous"></script>    </head>

<body class="girlkun-bg" id="hoangvietdung">
  <div class="container-md p-1 col-sm-12 col-lg-6"
    style="background: #FF99CC; border-radius: 7px; border: 1px solid #FFFFFF; box-shadow: 0 0 15px #66FFFF;">
                 


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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js';
        script.onload = function () {
            particlesJS("snow", {
                "particles": {
                    "number": {
                        "value": 75,
                        "density": {
                            "enable": true,
                            "value_area": 400
                        }
                    },
                    "color": {
                        "value": "#d3077d"
                    },
                    "opacity": {
                        "value": 1,
                        "random": true,
                        "anim": {
                            "enable": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true
                        }
                    },
                    "line_linked": {
                        "enable": true
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "top",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 300,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "events": {
                        "onhover": {
                            "enable": false
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": false
                    }
                },
                "retina_detect": true
            });
        }
        document.head.append(script);
    });

</script>


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
            <div class="text-center">
            <!-- <img class="avatar" src="<?php if($_gender == 0){$avatar="avatar/andanh.png";}else{$avatar = $_gender;}echo $avatar;?>" style="width: 50px; height: 55px;"> -->
            <br>
            <b class="text-white"><?php echo $_name;?></b>
        </div>
        <a href="/nap-tien.php" type="button" class="btn btn-action m-1 text-white"
           style="border-radius: 10px;">
            <i class="fa fa-money"></i>Nạp thẻ
        </a>
        <a href="/profile.php" type="button" class="btn btn-action m-1 text-white"
           style="border-radius: 10px;">
            <i class="fa fa-key"></i>thông tin
        </a>

        <a href="/change-password.php" type="button" class="btn btn-action m-1 text-white"
           style="border-radius: 10px;">
            <i class="fa fa-key"></i>Đổi mật khẩu
        </a>
        <?php if($_is_admin == 1){
        echo'
         <a href="/admin.php" type="button" class="btn btn-action m-1 text-white"
           style="border-radius: 10px;">
            <i class="fa fa-key"></i>admin
        </a>';
        }?>
             <a href="/out.php" type="button" class="btn btn-action m-1 text-white"
           style="border-radius: 10px;">
            <i class="fa fa-sign-out"></i>Đăng xuất
        </a>
    
    <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;" class="text-center">
        <img height="12" src="assets/images/icon/12.png" style="vertical-align: middle;"> 
        <span class="text-white" style="vertical-align: middle;">Dành cho người chơi trên 12 tuổi. Chơi quá 180 phút mỗi ngày sẽ có hại sức khỏe.</span>
    </div>
</div>
<?php
}
?>

