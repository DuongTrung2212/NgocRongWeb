<?php
include ('head.php');
?>

<div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">

    <body>
        <style>
            th,
            td {
                white-space: nowrap;
                padding: 2px 4px !important;
                font-size: 11px;
            }
        </style>
        <div class="container color-forum pt-1 pb-1">
            <div class="row">
                <div class="col"> <a href="dien-dan" style="color: white">Quay lại diễn đàn</a> </div>
            </div>
        </div>
        <div class="container color-forum pt-2">
            <div class="row">
                <div class="col">
                    <h6 class="text-center">BẢNG XẾP HẠNG ĐUA TOP SỨC MẠNH NGỌC RỒNG KUROKO</h6>
                    <table class="table table-borderless text-center">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Nhân vật</th>
                                <th>Sức Mạnh</th>
                                <th>Đệ Tử</th>
                                <th>Hành Tinh</th>
                                <th>Tổng</th>
                            </tr>
                        <tbody>
                            <?php
                            $countTop = 1;
                            $data = mysqli_query($conn, "SELECT name, gender, 
    CASE 
        WHEN gender = 1 THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED)
        WHEN gender = 2 THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED)
        ELSE CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED)
    END AS second_value,
    SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(pet, '$[1]')), ',', 2), ',', -1) AS detu_sm,
    CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED) + CAST(COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(pet, '$[1]')), ',', 2), ',', -1), '0') AS SIGNED) AS tongdiem
FROM player
ORDER BY tongdiem DESC
LIMIT 10;");
                            if (mysqli_num_rows($data) > 0) { // Check the number of returned results
                                while ($row = mysqli_fetch_array($data)) {
                                    ?>
                                    <tr class="top_<?php echo $countTop; ?>">
                                        <td>
                                            <?php echo $countTop++; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $value = $row['second_value'];

                                            if ($value != '') {
                                                if ($value > 1000000000) {
                                                    echo number_format($value / 1000000000, 1, '.', '') . ' tỷ';
                                                } elseif ($value > 1000000) {
                                                    echo number_format($value / 1000000, 1, '.', '') . ' Triệu';
                                                } elseif ($value >= 1000) {
                                                    echo number_format($value / 1000, 1, '.', '') . ' k';
                                                } else {
                                                    echo number_format($value, 0, ',', '');
                                                }
                                            } else {
                                                echo 'Không có chỉ số sức mạnh';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $value = $row['detu_sm'];

                                            if ($value != '') {
                                                if ($value > 1000000000) {
                                                    echo number_format($value / 1000000000, 1, '.', '') . ' tỷ';
                                                } elseif ($value > 1000000) {
                                                    echo number_format($value / 1000000, 1, '.', '') . ' Triệu';
                                                } elseif ($value >= 1000) {
                                                    echo number_format($value / 1000, 1, '.', '') . ' k';
                                                } else {
                                                    echo number_format($value, 0, ',', '');
                                                }
                                            } else {
                                                echo 'Không đệ tử';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['gender'] == 0) {
                                                echo "Trái đất";
                                            } elseif ($row['gender'] == 1) {
                                                echo "Namec";
                                            } elseif ($row['gender'] == 2) {
                                                echo "Xayda";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $total = $row['tongdiem'];

                                            if ($total > 1000000000) {
                                                echo number_format($total / 1000000000, 1, '.', '') . ' tỷ';
                                            } elseif ($total > 1000000) {
                                                echo number_format($total / 1000000, 1, '.', '') . ' Triệu';
                                            } elseif ($total >= 1000) {
                                                echo number_format($total / 1000, 1, '.', '') . ' k';
                                            } else {
                                                echo number_format($total, 0, ',', '');
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo 'Máy Chủ 1 chưa có thông kê bảng xếp hạng!';
                            }
                            ?>


                        </tbody>
                    </table>
                    <div class="text-right">
                        <small>Cập nhật lúc:
                            <?php echo date('H:i d/m/Y'); ?>
                        </small>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h6 class="text-center">BẢNG XẾP HẠNG ĐUA TOP NẠP NGỌC RỒNG KUROKO</h6>
                    <table class="table table-borderless text-center">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Tổng Nạp</th>
                            </tr>
                        <tbody>
                            <?php
                            $countTop = 1;
                            $data = mysqli_query($conn, "SELECT username, tongnap FROM account ORDER BY tongnap DESC LIMIT 10");
                            if (mysqli_num_rows($data) > 0) { // Check the number of returned results
                                while ($row = mysqli_fetch_array($data)) {
                                    ?>
                                    <tr class="top_<?php echo $countTop; ?>">
                                        <td>
                                            <?php echo $countTop++; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['username']); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $value = $row['tongnap'];

                                            if ($value != '') {
                                                if ($value > 1000000000) {
                                                    echo number_format($value / 1000000000, 1, '.', '') . ' tỷ';
                                                } elseif ($value > 1000000) {
                                                    echo number_format($value / 1000000, 1, '.', '') . ' Triệu';
                                                } elseif ($value >= 1000) {
                                                    echo number_format($value / 1000, 1, '.', '') . ' k';
                                                } else {
                                                    echo number_format($value, 0, ',', '');
                                                }
                                            } else {
                                                echo 'Không có chỉ số sức mạnh';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo 'Máy Chủ 1 chưa có thông kê bảng xếp hạng!';
                            }
                            ?>


                        </tbody>
                    </table>
                    <div class="text-right">
                        <small>Cập nhật lúc:
                            <?php echo date('H:i d/m/Y'); ?>
                        </small>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h6 class="text-center">BẢNG XẾP HẠNG ĐUA TOP NHIỆM VỤ NGỌC RỒNG KUROKO</h6>
                    <table class="table table-borderless text-center">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Nhiệm Vụ</th>
                            </tr>
                        <tbody>
                            <?php
                            $countTop = 1;
                            $data = mysqli_query($conn, "SELECT name, JSON_EXTRACT(data_task, '$[0]') AS second_value
						FROM player
						ORDER BY CAST(JSON_EXTRACT(data_task, '$[0]') AS UNSIGNED) DESC
						LIMIT 10;");
                            if (mysqli_num_rows($data) > 0) { // Check the number of returned results
                                while ($row = mysqli_fetch_array($data)) {
                                    ?>
                                    <tr class="top_<?php echo $countTop; ?>">
                                        <td>
                                            <?php echo $countTop++; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </td>
                                        <td>
                                        Nhiện Vụ :    <?php echo htmlspecialchars($row['second_value']); ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo 'Máy Chủ 1 chưa có thông kê bảng xếp hạng!';
                            }
                            ?>


                        </tbody>
                    </table>
                    <div class="text-right">
                        <small>Cập nhật lúc:
                            <?php echo date('H:i d/m/Y'); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-secondary border-top"></div>
        <div class="container pt-4 pb-4 text-white">
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <div style="font-size: 13px" class="text-dark">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body><!-- Bootstrap core JavaScript -->

</html>
<!--
# SOURCE WEBSITE NGOCRONGSAO CREATED BY NGUYEN DUC KIEN
# GITHUB: @NTDUCKIEN
# ZALO: 0981374169
# NGOCRONGSAO VERSION 1.0
 -->