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
                                        <h4 style="display: inline-block; margin-right: 10px;">ĐỔI THỎI VÀNG</h4>
                                        <br>
                                        <p>- Khi đổi xong hãy thoát game ra vào lại nhé</p>
                                        <br>
                                        <form method="POST" onsubmit="event.preventDefault(); changeGold();">
                                            <select class="form-control form-control-alternative" name="vnd_amount"
                                                id="vnd_amount" required>
                                                <option value="">Chọn Số Dư</option>
                                                <option value="10000">10,000 VNĐ</option>
                                                <option value="20000">20,000 VNĐ</option>
                                                <option value="30000">30,000 VNĐ</option>
                                                <option value="50000">50,000 VNĐ</option>
                                                <option value="100000">100,000 VNĐ</option>
                                                <option value="200000">200,000 VNĐ</option>
                                                <option value="300000">300,000 VNĐ</option>
                                                <option value="500000">500,000 VNĐ</option>
                                                <option value="1000000">1,000,000 VNĐ</option>
                                            </select>
                                            <label>Số thỏi vàng sẽ nhận: <span class="font-weight-bold"
                                                    id="gold">0</span> thỏi</label>
                                            <br>
                                            <br>
                                            <button
                                                class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100"
                                                name="doithoivang" type="submit">Thực hiện</button>
                                        </form>
                                        <div id="customToast" class="custom-toast"></div>
                                        <script>
                                            function changeGold() {
                                                var gold = document.querySelector("[name=vnd_amount]").value;
                                                var username = '<?= $_Username ?>';

                                                fetch('/Api/Gold', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        vnd_amount: gold,
                                                        username: username
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

                                                // Tự đóng thông báo sau 3 giây
                                                setTimeout(function () {
                                                    toast.style.display = 'none';
                                                }, 3000);
                                            }

                                            document.getElementById('vnd_amount').addEventListener('change', function () {
                                                var vndAmount = parseInt(this.value);
                                                var goldQuantity = 0;
                                                var options = [
                                                    { amount: 10000, quantity: 25 },
                                                    { amount: 20000, quantity: 60 },
                                                    { amount: 30000, quantity: 90 },
                                                    { amount: 50000, quantity: 160 },
                                                    { amount: 100000, quantity: 360 },
                                                    { amount: 200000, quantity: 670 },
                                                    { amount: 500000, quantity: 1700 },
                                                    { amount: 1000000, quantity: 3500 }
                                                ];

                                                for (var i = 0; i < options.length; i++) {
                                                    if (options[i].amount === vndAmount) {
                                                        goldQuantity = options[i].quantity;  // Không cần nhân với $giatri nữa
                                                        break;
                                                    }
                                                }

                                                document.getElementById('gold').textContent = goldQuantity;
                                            });
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