<?php
include '../../Controllers/Connections.php';
include '../../Controllers/Configs.php';
include '../../Controllers/Session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postData = json_decode(file_get_contents('php://input'), true);
    $vnd = $postData['vnd_amount'];
    $username = $postData['username'];

    $success = updateAccount($vnd, $username, $conn);

    if ($success) {
        $response = array(
            'success' => true,
            'message' => 'Đổi thỏi vàng thành công!'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
        );
    }
    echo json_encode($response);
}

function updateAccount($vnd, $username, $conn)
{
    $goldQuantity = calculateGoldQuantity($vnd);

    // Chuẩn bị truy vấn SQL
    $sql = "UPDATE account SET vnd = vnd - :vnd, thoi_vang = thoi_vang + :goldQuantity WHERE username = :username";
    $stmt = $conn->prepare($sql);

    // Bind các giá trị vào truy vấn
    $stmt->bindParam(':vnd', $vnd, PDO::PARAM_INT);
    $stmt->bindParam(':goldQuantity', $goldQuantity, PDO::PARAM_INT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    // Thực thi truy vấn
    $success = $stmt->execute();

    // Đóng kết nối và trả về kết quả
    return $success;
}

function calculateGoldQuantity($vnd)
{
    $options = array(
        array("amount" => 10000, "quantity" => 25),
        array("amount" => 20000, "quantity" => 60),
        array("amount" => 30000, "quantity" => 90),
        array("amount" => 50000, "quantity" => 160),
        array("amount" => 100000, "quantity" => 360),
        array("amount" => 200000, "quantity" => 670),
        array("amount" => 500000, "quantity" => 1700),
        array("amount" => 1000000, "quantity" => 3500)
    );

    foreach ($options as $option) {
        if ($option['amount'] == $vnd) {
            return $option['quantity'];
        }
    }

    return 0;
}