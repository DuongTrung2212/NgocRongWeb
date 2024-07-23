<?php
include '../../Controllers/Header.php';
if ($_Login === null) {
    echo '<script>window.location.href = "/";</script>';
}
?>
<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <div class="ant-col ant-col-24">
            <div class="ant-list ant-list-split">
                <div class="ant-spin-nested-loading">
                    <div class="ant-spin-container">
                        <ul class="ant-list-items">
                            <table cellpadding="0" cellspacing="0" width="99%"
                                style="table-layout: fixed; overflow-wrap: break-word; border-spacing: 0px 15px; border-collapse: separate; text-indent: initial;">
                                <tbody>
                                    <tr>
                                        <td align="center" style="width: 75px; vertical-align: top;">
                                            <img class="posts_avatar__kFWsK" src="..//Assets/Images/osFJ5m8.png">
                                            <br>
                                            <small>
                                                <b>
                                                    <font style="color: red;">ADMIN</font>
                                                    <font>
                                                        <p><i>Admin </i>

                                                        </p>
                                                    </font>
                                                </b>
                                            </small>
                                        </td>
                                        <td class="posts_boxContent__XjPnA">
                                            <div class="posts_contentPost___PyGu">
                                                <div class="posts_title__P1NsS">Kich Hoạt Thành Viên</div>
                                                <div class="posts_boxTime__bFU28"><span
                                                        class="posts_time__PFYQE"></span></div>
                                                <div>
                                                    <div class="fr-view" style="background-color: rgb(255, 255, 255);">
                                                        <div>
                                                            <h2>Chào mừng bạn đến với
                                                                <?= $_ServerName ?>
                                                            </h2>
                                                            <p>
                                                                Hãy cùng chúng tôi khám phá không gian mới, nơi bạn có
                                                                thể trải nghiệm những điều tuyệt vời và kích hoạt sức
                                                                mạnh của tài khoản!
                                                            </p>
                                                            <br>
                                                            <h3>Thời Gian:</h3>
                                                            <p>Tham gia ngay, không còn chờ đợi!</p>
                                                            <br>
                                                            <h3>Nội Dung:</h3>
                                                            <p>
                                                                Để bắt đầu, bạn chỉ cần nạp tối thiểu 20.000 VND để mở
                                                                khóa tài khoản và bắt đầu sử dụng. Với
                                                                <?= $_ServerName ?>, bạn sẽ được tham gia vào một cộng
                                                                đồng đa dạng và trải nghiệm những tính năng tuyệt vời.
                                                            </p>
                                                            <br>
                                                            <?php if ($_Status == 0) { ?>
                                                                <button
                                                                    class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-25"
                                                                    onclick="activateAccount()"> Kích hoạt ngay </button>
                                                            <?php } else { ?>
                                                                <button
                                                                    class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-25"
                                                                    disabled>
                                                                    Đã kích hoạt </button>
                                                            <?php } ?>
                                                        </div>
                                                        <div id="customToast" class="custom-toast"></div>
                                                        <script>
                                                            function activateAccount() {
                                                                var status = '<?php echo $_Status; ?>';
                                                                var coins = '<?php echo $_Coins; ?>';
                                                                var username = '<?php echo $_Username; ?>';

                                                                fetch('/Api/Active', {
                                                                    method: 'POST',
                                                                    headers: {
                                                                        'Content-Type': 'application/json'
                                                                    },
                                                                    body: JSON.stringify({
                                                                        status: status,
                                                                        coins: coins,
                                                                        username: username
                                                                    })
                                                                })
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        if (data.success) {
                                                                            showCustomToast(data.message, 'success');
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

                                                                // Tự đóng thông báo sau 3 giây
                                                                setTimeout(function () {
                                                                    toast.style.display = 'none';
                                                                }, 3000);
                                                            }
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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