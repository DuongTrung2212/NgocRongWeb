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
                                        <h4 style="display: inline-block; margin-right: 10px;">NẠP SỐ DƯ</h4>
                                        <br>
                                        <?php if ($_AutoMember == 1) { ?>
                                            <p>- Máy chủ đang bật tính năng tự động mở thành viên khi nạp mệnh giá 20,000 VNĐ
                                            </p>
                                            <br>
                                        <?php } ?>
                                        <form method="POST" onsubmit="event.preventDefault(); PostCard();">
                                            <tbody>
                                                <label>Loại thẻ:</label>
                                                <select class="form-control form-control-alternative" name="telco"
                                                    required>
                                                    <option value="">Chọn loại thẻ</option>
                                                    <option value="VIETTEL">Viettel</option>
                                                    <option value="VINAPHONE">Vinaphone</option>
                                                    <option value="MOBIFONE">Mobifone</option>
                                                </select>
                                                <label>Mệnh giá:</label>
                                                <select class="form-control form-control-alternative" name="amount"
                                                    required>
                                                    <option value="">Chọn mệnh giá</option>
                                                    <option value="10000">10.000</option>
                                                    <option value="20000">20.000</option>
                                                    <option value="30000">30.000</option>
                                                    <option value="50000">50.000</option>
                                                    <option value="100000">100.000</option>
                                                    <option value="200000">200.000</option>
                                                    <option value="300000">300.000</option>
                                                    <option value="500000">500.000</option>
                                                    <option value="1000000">1.000.000</option>
                                                </select>
                                                <label>Số seri:</label>
                                                <input type="text" class="form-control form-control-alternative"
                                                    name="serial" required />
                                                <label>Mã thẻ:</label>
                                                <input type="text" class="form-control form-control-alternative"
                                                    name="code" required /><br>
                                                <?php if ($_TrangThai == 0) { ?>
                                                    <button
                                                        class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100"
                                                        disabled>Bảo Trì</button>
                                                <?php } else { ?>
                                                    <button type="submit"
                                                        class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100"
                                                        name="submit">NẠP NGAY</button>
                                                <?php } ?>

                                            </tbody>
                                        </form>
                                        <div id="customToast" class="custom-toast"></div>
                                        <script>
                                            function PostCard() {
                                                var telco = document.querySelector("[name=telco]").value;
                                                var amount = document.querySelector("[name=amount]").value;
                                                var serial = document.querySelector("[name=serial]").value;
                                                var code = document.querySelector("[name=code]").value;
                                                var username = '<?= $_Username ?>';

                                                fetch('/Api/Post', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        telco: telco,
                                                        amount: amount,
                                                        serial: serial,
                                                        code: code,
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
                                        </script>
                                    </div>
                                    <div>
                                        <br>
                                        <br>
                                        <h6 class="text-center">LỊCH SỬ NẠP THẺ</h6>
                                        <hr>
                                        <style>
                                            .history-container {
                                                display: flex;
                                                overflow-x: hidden;
                                                /* Ẩn thanh scrollbar */
                                                position: relative;
                                            }

                                            .history-item {
                                                flex: 0 0 calc(35% - 5px);
                                                /* Thay đổi giá trị flex */
                                                padding: 10px;
                                                overflow: auto;
                                                position: relative;
                                            }

                                            .history-item p {
                                                margin: 0;
                                                white-space: nowrap;
                                            }

                                            .details-link {
                                                color: blue;
                                                text-decoration: underline;
                                                cursor: pointer;
                                                position: absolute;
                                                bottom: 10px;
                                                right: 10px;
                                            }
                                        </style>
                                        <?php
                                        if (isset($_Username)) {
                                            $limit = 3; // Số lượng dữ liệu trên mỗi trang
                                            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM `napthe` WHERE user_nap = :username");
                                            $stmt->bindParam(":username", $_Username);
                                            $stmt->execute();
                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $totalRecords = $result['total'];

                                            $totalPages = ceil($totalRecords / $limit);

                                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                            $offset = ($currentPage - 1) * $limit;

                                            $stmt = $conn->prepare("SELECT * FROM `napthe` WHERE user_nap = :username ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
                                            $stmt->bindParam(":username", $_Username);
                                            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
                                            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            if (count($result) > 0) {
                                                echo '<div class="history-container">';
                                                foreach ($result as $row) {
                                                    $status = '';

                                                    switch ($row['status']) {
                                                        case 1:
                                                            $status = 'Thẻ đúng';
                                                            break;
                                                        case 3:
                                                            $status = 'Thẻ sai';
                                                            break;
                                                        default:
                                                            $status = 'Chờ Duyệt';
                                                    }

                                                    $date = new DateTime($row['created_at']);
                                                    $formattedDate = $date->format('H:i d/m/Y');

                                                    echo '<div class="history-item">';
                                                    echo '<p><strong>ID:</strong> ' . $row['id'] . '</p>';
                                                    echo '<p><strong>Tình trạng:</strong> ' . $status . '</p>';
                                                    echo '<p><strong>Loại thẻ:</strong> ' . $row['telco'] . '</p>';
                                                    echo '<p><strong>Mệnh giá:</strong> ' . number_format($row['amount']) . 'đ</p>';
                                                    echo '<p><strong>Thông tin:</strong> ' . $row['code'] . ' / ' . $row['serial'] . '</p>';
                                                    echo '<p><strong>Thời gian nạp:</strong> ' . $formattedDate . '</p>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';

                                                // Hiển thị nút phân trang
                                                echo '<div class="col-7 ml-auto">';
                                                echo '<ul class="pagination justify-content-end">';
                                                if ($currentPage > 1) {
                                                    echo '<li><a class="ant-btn ant-btn-default header-btn-login w-25" href="?page=' . ($currentPage - 1) . '"><</a></li>';
                                                }
                                                $start_page = max(1, min($totalPages - 2, $currentPage - 1));
                                                $end_page = min($totalPages, max(2, $currentPage + 1));
                                                for ($i = 1; $i <= $totalPages; $i++) {
                                                    if ($i >= $start_page && $i <= $end_page) {
                                                        $class_name = "ant-btn ant-btn-default header-btn-login w-25";
                                                        if ($i == $currentPage) {
                                                            $class_name = "ant-btn ant-btn-default header-btn-login w-25";
                                                        }
                                                        echo '<li class="page-item"><a class="' . $class_name . '" href="?page=' . $i . '">' . $i . '</a></li>';
                                                    }
                                                }
                                                if ($currentPage < $totalPages) {
                                                    echo '<li><a class="ant-btn ant-btn-default header-btn-login w-25" href="?page=' . ($currentPage + 1) . '">></a></li>';
                                                }
                                                echo '</ul>';
                                                echo '</div>';

                                            }
                                        }
                                        ?>
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