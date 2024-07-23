<?php
include '../../Controllers/Header.php';

$Username = '';
$Password = '';
$Email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = htmlspecialchars(trim($_POST["Username"]));
    $Password = htmlspecialchars(trim($_POST["Password"]));

    if ($_AuthLog == 1) {
        $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Đang bảo trì đăng nhập, vui lòng thử lại sau!</div>';
        return;
    }

    if (!isValidInput($Username) || !isValidInput($Password)) {
        $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Tên đăng nhập và mật khẩu không được chứa kí tự đặc biệt.</div>';
        // Đặt lại captcha sau khi đăng ký thành công
        $_SESSION['captcha'] = generateCaptcha(6);
        
        
    } else {
        $captchaValue = isset($_POST["captcha"]) ? trim($_POST["captcha"]) : '';
        $captchaText = isset($_SESSION["captcha"]) ? $_SESSION["captcha"] : '';

        if (validateCaptcha($captchaValue, $captchaText)) {

            if (checkExistingUsername($conn, $Username)) {
                $_ThongBao = "<div class='text-danger pb-2 font-weight-bold'>Tài khoản đã tồn tại.</div>";
                // Đặt lại captcha sau khi đăng ký thành công
                $_SESSION['captcha'] = generateCaptcha(6);
            } else {
                if (insertAccount($conn, $Username, $Password, $Email)) {
                    $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Đăng kí thành công!!</div>';
                    // Đặt lại captcha sau khi đăng ký thành công
                    $_SESSION['captcha'] = generateCaptcha(6);
                } else {
                    $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Đăng ký thất bại.</div>';
                    // Đặt lại captcha sau khi đăng ký thành công
                    $_SESSION['captcha'] = generateCaptcha(6);
                }
            }

        } else {
            $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Captcha không đúng. Vui lòng nhập lại!'.$captchaValue .',' .$captchaText .' </div>';
            // Đặt lại captcha sau khi đăng ký thành công
            $_SESSION['captcha'] = generateCaptcha(6);
        }
    }
}
?>
<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <!-- load view -->
        <div class="ant-row">
            <div class="ant-col ant-col-24 home_page_bodyTitleList__UdhN_">Đăng Ký</div>
        </div>
        <div class="ant-col ant-col-24">
            <div class="ant-list ant-list-split">
                <div class="ant-spin-nested-loading">
                    <div class="ant-spin-container">
                        <ul class="ant-list-items">
                            <div class="container pt-5 pb-5">
                                <div class="row">
                                    <div class="col-lg-6 offset-lg-3">
                                        <h3>ĐĂNG KÝ |
                                            <?= $_ServerName ?>
                                        </h3>
                                        <?php if (!empty($_ThongBao)) {
                                            echo $_ThongBao;
                                        } ?>
                                        <form id="form" method="POST">
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Tài khoản:</label>
                                                <input class="form-control" type="text" name="Username" id="Username"
                                                    minlength="6" placeholder="Nhập tài khoản" required>
                                            </div>
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Mật khẩu:</label>
                                                <input class="form-control" type="Password" name="Password"
                                                    minlength="6" id="Password" placeholder="Nhập mật khẩu" required>
                                            </div>
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Email:</label>
                                                <input class="form-control" type="email" name="Email" id="Email"
                                                    placeholder="Nhập email của bạn" required>
                                            </div>
                                            <label><span class="text-danger">*</span> Mã xác minh:</label>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <input type="text" class="form-control" name="captcha" id="captcha"
                                                        maxlength="6" spellcheck="false" style="padding: 6px;"
                                                        placeholder="Nhập captcha ..." required>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" id="captcha"
                                                        style="background-color: #DCDCDC; font-weight: bold; color: #696969; width: 50%; margin-top: -8%; float: right;"
                                                        value=" <?php echo isset($_SESSION['captcha']) ? $_SESSION['captcha'] : ''; ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-check form-group">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="accept"
                                                        id="accept" checked="">
                                                    Đồng ý <a href=" ">Điều khoản sử dụng</a>
                                                </label>
                                            </div>
                                            <div id="notify" class="text-danger pb-2 font-weight-bold"></div>
                                            <button
                                                class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100"
                                                type="submit">ĐĂNG KÝ</button>
                                            <div style="display: flex; justify-content: center; margin-top: 5%">
                                                <a href="/Auth/Login" style="text-align: center;">Bạn Đã Có Tài
                                                    Khoản?</a>
                                            </div>

                                        </form>
                                        <script>
                                            window.onload = function () {
                                                var loggedIn = <?= ($_Login ? 'true' : 'null'); ?>; // Lấy giá trị từ biến $_login
                                                if (loggedIn) {
                                                    window.location.href = "/"; // Chuyển hướng nếu đã đăng nhập
                                                }
                                            };
                                        </script>
                                    </div>
                                </div>
                                <div id="paging" class="d-flex justify-content-end align-items-center flex-wrap">
                                </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- end load view -->
    </div>
</div>
<?php
include '../../Controllers/Footer.php';
?>