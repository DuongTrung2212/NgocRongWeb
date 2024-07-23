<?php
include '../../Controllers/Connections.php';
include '../../Controllers/Session.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postData = json_decode(file_get_contents('php://input'), true);

    $title = $postData['title'];
    $content = $postData['content'];
    $username = $postData['username'];

    $response = array();

    // Cập nhật tài khoản trong cơ sở dữ liệu
    $stmt = $conn->prepare('INSERT forum SET title = :title, content = :content, username = :username');
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':username', $username);
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $response = array(
            'success' => true,
            'message' => 'Đăng bài viết thành công!'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Có lỗi gì đó xảy ra. Vui lòng liên hệ Admin!'
        );
    }

    // Đảm bảo rằng dữ liệu được trả về là JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}