<?php
include '../../Controllers/Header.php';
if ($_Login === null) {
    echo '<script>window.location.href = "/Auth/Login";</script>';
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
                                        <h4 style="display: inline-block; margin-right: 10px;">ĐỔI MẬT KHẨU</h4>
                                        <br>
                                        <form method="POST" onsubmit="event.preventDefault(); ChangePass();">
                                            <tbody>
                                                <label>Mật khẩu hiện tại:</label>
                                                <input type="password" class="form-control form-control-alternative"
                                                    name="current_password" minlength="6" required />
                                                <?php if (!empty($_Security)) { ?>
                                                    <label>Mã bảo vệ:</label>
                                                    <input type="password" class="form-control form-control-alternative"
                                                        name="security" minlength="6" required />
                                                <?php } ?>
                                                <label>Mật khẩu mới:</label>
                                                <input type="password" class="form-control form-control-alternative"
                                                    name="newpassword" minlength="6" required />
                                                <label>Xác nhận mật khẩu mới:</label>
                                                <input type="password" class="form-control form-control-alternative"
                                                    name="newpassword_confirm" minlength="6" required /><br>
                                                <button type="submit"
                                                    class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100"
                                                    name="submit">ĐỔI NGAY</button>
                                            </tbody>
                                        </form>
                                        <div id="customToast" class="custom-toast"></div>

                                        <script>
                                            function ChangePass() {
                                                var current_password = document.querySelector("[name=current_password]").value;
                                                var newpassword = document.querySelector("[name=newpassword]").value;
                                                var newpassword_confirm = document.querySelector("[name=newpassword_confirm]").value;
                                                var username = '<?= $_Username ?>';
                                                var security = document.querySelector("[name=security]").value; // Lấy giá trị mã bảo vệ

                                                var isValid = passwordCheck(current_password, newpassword, newpassword_confirm);
                                                if (isValid) {
                                                    fetch('/Api/Password', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json'
                                                        },
                                                        body: JSON.stringify({
                                                            current_password: current_password, // Thêm trường này để gửi mật khẩu hiện tại
                                                            newpassword: newpassword,
                                                            newpassword_confirm: newpassword_confirm,
                                                            username: username,
                                                            password_verify: security // Truyền giá trị mã bảo vệ
                                                        })
                                                    })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (data.success) {
                                                                showCustomToast(data.message, 'success');
                                                                setTimeout(function () {
                                                                    location.reload();
                                                                }, 2000);
                                                            } else {
                                                                showCustomToast(data.message, 'error');
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error:', error);
                                                            showCustomToast('Có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
                                                        });
                                                }
                                            }

                                            function showCustomToast(message, type) {
                                                var toast = document.getElementById('customToast');
                                                toast.textContent = message;
                                                toast.style.display = 'block';
                                                toast.style.backgroundColor = type === 'success' ? '#4CAF50' : '#F44336';

                                                // Tự đóng thông báo sau 3 giây
                                                setTimeout(function () {
                                                    toast.style.display = 'none';
                                                }, 3000);
                                            }

                                            function passwordCheck(current_password, newpassword, newpassword_confirm) {
                                                var hasSpecialChar = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
                                                var hasUpperCase = /[A-Z]/;

                                                if (hasSpecialChar.test(newpassword) || hasUpperCase.test(newpassword)) {
                                                    showCustomToast("Mật khẩu không được chứa ký tự đặc biệt hoặc chữ hoa", 'error');
                                                    return false; // Không hợp lệ, dừng việc gửi dữ liệu
                                                } else if (newpassword !== newpassword_confirm) {
                                                    showCustomToast("Mật khẩu mới không khớp", 'error');
                                                    return false; // Không hợp lệ, dừng việc gửi dữ liệu
                                                }
                                                return true; // Hợp lệ, cho phép gửi dữ liệu
                                            }
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
        </div>
    </div> <!-- end load view -->
</div>
</div>
<?php
include '../../Controllers/Footer.php';
?>