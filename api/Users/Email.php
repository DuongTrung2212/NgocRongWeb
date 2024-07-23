<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Đường dẫn đến file autoload.php của PHPMailer
include '../../Controllers/Connections.php';
include '../../Controllers/Configs.php';
include '../../Controllers/Session.php';

// Kiểm tra xác minh Email và gửi mã xác minh
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);
    $Email = $postData['email'];
    $accountExists = checkExistingEmail($conn, $Email);

    if (!$accountExists) {
        $response = array(
            'success' => false,
            'message' => 'Email không tồn tại trong tài khoản'
        );
    } else {
        $verificationCode = mt_rand(100000, 999999);
        $_SESSION['verification_code'] = $verificationCode;
        $_SESSION['Email'] = $Email;

        // Send verification Email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ForgotEmail;
            $mail->Password = $_ForgotPass;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom($_ForgotEmail, $_ServerName);
            $mail->addAddress($Email);

            //Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Quên Mật Khẩu [ Nguyen Duc Kien ]';
            $mail->Body = '
                <html>
                <head>
                    <title>Xác nhận mật khẩu mới</title>
                </head>
                <body style="font-family: Arial, sans-serif;">

                    <p>Kính gửi quý khách hàng,</p>

                    <span>Dưới đây là mật khẩu mới của bạn: </span><b>' . $verificationCode . '</b>

                    <p>Vui lòng không tiết lộ mật khẩu mới cho bất kì ai! Bao gồm cả admin tại máy chủ</p>

                    <p>Xin cảm ơn bạn đã tin dùng dịch vụ của chúng tôi.</p>

                    <span>Trân trọng, <b>Nguyễn Đức Kiên</b></span>

                </body>
                </html>
                ';

            $mail->send();

            $query = "UPDATE account SET password = :verificationCode WHERE email = :Email";
            $statement = $conn->prepare($query);
            $statement->bindParam(':verificationCode', $verificationCode, PDO::PARAM_STR);
            $statement->bindParam(':Email', $Email, PDO::PARAM_STR);
            $result = $statement->execute();
            $response = array(
                'success' => true,
                'message' => 'Đã gửi mật khẩu mới về Email: ' . $Email
            );
        } catch (Exception $e) {
            $response = array(
                'success' => false,
                'message' => 'Có lỗi gì đó xảy ra. Vui lòng liên hệ Admin!'
            );
        }
    }

    // Đảm bảo rằng dữ liệu được trả về là JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
