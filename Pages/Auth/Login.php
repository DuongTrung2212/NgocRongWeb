<?php
include '../../Controllers/Header.php';
function isValidUsername($Username)
{
    return ctype_alnum($Username);
}

function loginUser($Username, $Password, $conn)
{
    global $_ThongBao, $_AuthLog;

    try {
        if ($_AuthLog == 1) {
            $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Đang bảo trì đăng nhập, vui lòng thử lại sau!</div>';
            return;
        }

        $stmt = $conn->prepare("SELECT * FROM account WHERE username = :Username");
        $stmt->bindParam(':Username', $Username, PDO::PARAM_STR);
        $stmt->execute();
        $select = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($select !== false && $select['password'] == $Password) {
            // Mã hoá đầu ra để tránh XSS khi hiển thị Username
            $_SESSION['account'] = htmlspecialchars($Username, ENT_QUOTES, 'UTF-8');
            $_SESSION['id'] = $select['id'];
            echo '<script>window.location.href = "/";</script>';
            exit();
        } else {
            $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Tên đăng nhập hoặc mật khẩu không hợp lệ, vui lòng kiểm tra lại!</div>';
        }
    } catch (PDOException $e) {
        $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại sau!</div>';
    }
}

if (isset($_POST['Username']) && isset($_POST['Password'])) {
    $Username = htmlspecialchars(trim($_POST['Username']), ENT_QUOTES, 'UTF-8');
    $Password = htmlspecialchars(trim($_POST['Password']), ENT_QUOTES, 'UTF-8');

    if (!isValidUsername($Username)) {
        $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Tên đăng nhập chỉ được chứa kí tự và số!</div>';
    } else {
        loginUser($Username, $Password, $conn);
    }
} elseif (isset($_POST['submit'])) {
    $_ThongBao = '<div class="text-danger pb-2 font-weight-bold">Vui lòng nhập tên đăng nhập và mật khẩu!</div>';
}
?>
<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <div class="ant-col ant-col-24">
            <div class="ant-list ant-list-split">
                <div class="ant-spin-nested-loading">
                    <div class="ant-spin-container">
                        <ul class="ant-list-items">
                            <div class="container pt-5 pb-5">
                                <div class="row">
                                    <div class="col-lg-6 offset-lg-3">
                                        <h4>ĐĂNG NHẬP |
                                            <?= $_ServerName ?>
                                        </h4>
                                        <?php if (!empty($_ThongBao)) {
                                            echo $_ThongBao;
                                        } ?>
                                        <form id="form" method="POST">
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Tài khoản:</label>
                                                <input class="form-control" type="text" name="Username" id="Username"
                                                    placeholder="Nhập tài khoản">
                                            </div>
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Mật khẩu:</label>
                                                <input class="form-control" type="password" name="Password"
                                                    id="Password" placeholder="Nhập mật khẩu">
                                            </div>
                                            <div class="form-check form-group">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="accept"
                                                        id="accept" checked="">
                                                    Ghi nhớ đăng nhập
                                                </label>
                                                <a href="/Auth/Forgot-Password"
                                                    style="float: right;">Quên mật
                                                    khẩu</a>
                                            </div>
                                            <div id="notify" class="text-danger pb-2 font-weight-bold"></div>
                                            <button
                                                class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100"
                                                type="submit">Đăng nhập</button>
                                            <div style="display: flex; justify-content: center; margin-top: 5%">
                                                <a href="/Auth/Register" style="text-align: center;">Bạn Chưa Có Tài
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