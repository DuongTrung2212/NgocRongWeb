<?php
session_start();
require_once('../../Controllers/Connections.php');
require_once('../../Controllers/Configs.php');
include('ApiMB.php');

if (!isset($_GET['users']) || $_GET['users'] !== $userloginmbbank_config) {
    exit('Không tìm thấy key! Không thể truy cập.');
}

$userloginmbbank = $userloginmbbank_config;
$passmbbank = $passmbbank_config;
$stkmbbank = $stkmbbank_config;
$deviceId = $deviceIdCommon_goc_config;
if (empty($userloginmbbank) || empty($passmbbank) || empty($stkmbbank)) {
    exit('Vui lòng điền tài khoản đăng nhập, mật khẩu và số tài khoản');
}

$mbbank = new MBBANK;
$mbbank->user = $userloginmbbank;
$mbbank->pass = $passmbbank;
$text_captcha = $mbbank->bypass_captcha_web2m('413145b2f6d981e32d0ee69a56b0e839');
$login = json_decode($mbbank->login($text_captcha), true);
if (isset($login['result']['message']) && ($login['result']['message'] == "Capcha code is invalid" || $login['result']['message'] == 'Customer is invalid')) {
    exit('Captcha không chính xác hoặc thông tin không chính xác');
}

$existingAccount = $conn->query("SELECT userlogin FROM cpanel WHERE userlogin = '$userloginmbbank'")->fetch();
if ($existingAccount) {
    $stmt = $conn->prepare("UPDATE cpanel SET stk = ?, name = ?, password = ?, sessionId = ?, deviceId = ?, token = ?, time = ? WHERE userlogin = ?");
    $stmt->execute([$stkmbbank, $login['cust']['nm'] ?? '', $passmbbank, $login['sessionId'] ?? '', $deviceId, CreateToken(), time(), $userloginmbbank]);

    if ($stmt->rowCount() > 0) {
        exit('Cập nhật tài khoản thành công');
    } else {
        exit('Lỗi khi cập nhật tài khoản');
    }
} else {
    $stmt = $conn->prepare("INSERT INTO cpanel (userlogin, stk, name, password, sessionId, deviceId, token, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userloginmbbank, $stkmbbank, $login['cust']['nm'] ?? '', $passmbbank, $login['sessionId'] ?? '', $deviceId, CreateToken(), time()]);

    if ($stmt->rowCount() > 0) {
        exit('Thêm mới tài khoản thành công');
    } else {
        exit('Lỗi khi thêm mới tài khoản');
    }
}