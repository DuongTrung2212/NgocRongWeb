<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

$_Login = null;
$_Users = $_SESSION['account'] ?? null;
$_Ip = $_SERVER['REMOTE_ADDR'];

function fetchUserData($conn, $username)
{
    $stmt = $conn->prepare("SELECT * FROM account WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user_arr = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_arr) {
        return null;
    }

    $user_data = [];
    foreach ($user_arr as $key => $value) {
        $user_data[$key] = ($value !== null) ? htmlspecialchars($value) : '';
    }

    return [
        "_id" => $user_data['id'],
        "_username" => $user_data['username'],
        "_password" => $user_data['password'],
        "_gmail" => $user_data['email'],
        "_admin" => $user_data['admin'],
        "_coin" => $user_data['vnd'],
        "_tcoin" => $user_data['tongnap'],
        "_status" => $user_data['active'],
        "_security" => $user_data['mabaove'],
        "ip" => $user_data['ip_address'],
        "thoivang" => $user_data['thoi_vang'],
    ];
}

if ($_Users !== null) {
    $_Login = "on";
    $user_data = fetchUserData($conn, $_Users);
    $user_sanitized = array_map('htmlspecialchars', $user_data);

    $_Id = $user_sanitized['_id'];
    $_Username = $user_sanitized["_username"];
    $_Password = $user_sanitized["_password"];
    $_Email = $user_sanitized["_gmail"];
    $_Admin = $user_sanitized["_admin"];
    $_Coins = $user_sanitized["_coin"];
    $_TCoins = $user_sanitized["_tcoin"];
    $_Status = $user_sanitized["_status"];
    $_Security = $user_sanitized["_security"];
    $_Ip = $user_sanitized['ip'];
    $_ThoiVang = $user_sanitized['thoivang'];
}

function formatMoney($number)
{
    if (!is_numeric($number) || $number === null) {
        return '0 VNĐ';
    }

    $suffix = '';
    if ($number >= 1000000000000) {
        $number /= 1000000000000;
        $suffix = ' Tỷ';
    } elseif ($number >= 1000000000) {
        $number /= 1000000000;
        $suffix = ' Tỷ';
    } elseif ($number >= 1000000) {
        $number /= 1000000;
        $suffix = ' Triệu';
    } elseif ($number >= 1000) {
        $number /= 1000;
        $suffix = ' K';
    }

    return number_format($number) . $suffix;
}

function isValidInput($input)
{
    return preg_match('/^[a-zA-Z0-9_]+$/', $input) && strlen($input) <= 255;
}

function validateCaptcha($input, $captchaText)
{
    return strtoupper($input) === strtoupper($captchaText);
}

function generateCaptcha($length = 6)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $captcha;
}

// if (!isset($_POST["captcha"])) {
//     $_SESSION['captcha'] = generateCaptcha(6);
// }

function checkExistingUsername($conn, $Username)
{
    $stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE username = :username");
    $stmt->bindValue(':username', $Username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function checkExistingEmail($conn, $Email)
{
    $stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE email = :email");
    $stmt->bindValue(':email', $Email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function insertAccount($conn, $Username, $Password, $Email)
{
    $stmt = $conn->prepare("INSERT INTO account (username, password, email) VALUES (:username, :password, :email)");
    $stmt->bindValue(':username', $Username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $Password, PDO::PARAM_STR);
    $stmt->bindValue(':email', $Email, PDO::PARAM_STR);
    return $stmt->execute();
}