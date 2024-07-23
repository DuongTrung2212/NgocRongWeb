<?php
include '../../Controllers/Header.php';
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
                                        <h4>QUÊN MẬT KHẨU</h4>
                                        <form id="form" method="POST">
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Email:</label>
                                                <input class="form-control" type="email" name="email"
                                                    placeholder="Nhập email của bạn">
                                            </div>
                                            <br>
                                            <button
                                                class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100"
                                                type="button" onclick="sendEmail()">Xác Nhận</button>
                                        </form>
                                        <div id="customToast" class="custom-toast"></div>

                                        <script>
                                            function sendEmail() {
                                                var email = document.querySelector("[name=email]").value;

                                                fetch('/Api/Email', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        email: email
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

                                            function showCustomToast(message, type) {
                                                var toast = document.getElementById('customToast');
                                                toast.textContent = message;
                                                toast.style.display = 'block';
                                                toast.style.backgroundColor = type === 'success' ? '#4CAF50' : '#F44336';

                                                setTimeout(function () {
                                                    toast.style.display = 'none';
                                                }, 3000);
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
        </div> <!-- end load view -->
    </div>
</div>
<?php
include '../../Controllers/Footer.php';
?>