<?php
include '../../Controllers/Connections.php';
include '../../Controllers/Session.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postData = json_decode(file_get_contents('php://input'), true);

    $current_password = $postData['current_password'];
    $newpass = $postData['newpassword'];
    $newconfirm = $postData['newpassword_confirm'];
    $username = $postData['username'];
    $security = isset($postData['security']) ? $postData['security'] : null;

    $response = array();

    // Kiểm tra mã bảo vệ nếu có
    if (!empty($_Security) && $security == $_Security) {
        $response = array(
            'success' => false,
            'message' => 'Mã bảo vệ không đúng!'
        );
    } else {
        // Kiểm tra mật khẩu cũ và mật khẩu mới
        if ($current_password == $newpass) {
            $response = array(
                'success' => false,
                'message' => 'Mật khẩu cũ không được giống mật khẩu mới'
            );
        } elseif ($newpass != $newconfirm) {
            $response = array(
                'success' => false,
                'message' => 'Mật khẩu mới và xác nhận mật khẩu không giống nhau!'
            );
        } else {
            // Cập nhật tài khoản trong cơ sở dữ liệu
            $stmt = $conn->prepare('UPDATE account SET password = :newpassword WHERE username = :username');
            $stmt->bindValue(':newpassword', $newpass);
            $stmt->bindValue(':username', $username);
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Đổi mật khẩu thành công!'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Có lỗi gì đó xảy ra. Vui lòng liên hệ Admin!'
                );
            }
        }
    }

    // Đảm bảo rằng dữ liệu được trả về là JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}