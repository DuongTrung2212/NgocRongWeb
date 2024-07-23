<?php
require_once '../../Controllers/Connections.php';
require_once '../../Controllers/Configs.php';
require_once '../../Controllers/Session.php';
include 'ApiMB.php';

function generateRandom($length = 20)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return htmlspecialchars($randomString, ENT_QUOTES, 'UTF-8');
}

date_default_timezone_set('Asia/Ho_Chi_Minh');
$timeStart = date("YmdHis") . '00';
$DeviceCreate = generateRandom(8) . "-mbib-0000-0000-$timeStart";
$mbbank = new MBBANK();
$mbbank->deviceIdCommon_goc = $DeviceCreate;

function getCaptcha($mbbank, $captcha_type)
{
    $captcha = json_decode($mbbank->get_captcha(), true);
    if ($captcha_type == '2024') {
        $base64 = htmlspecialchars($captcha['imageString'], ENT_QUOTES, 'UTF-8');
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://103.153.64.187:8277/api/captcha/mbbank',
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(array("base64" => $base64)),
                CURLOPT_HTTPHEADER => array('Content-Type: application/json')
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);
        return htmlspecialchars($result['captcha'], ENT_QUOTES, 'UTF-8');
    }
    return null;
}

function loginMBBank($mbbank, $UserMB, $PassMB, $captcha)
{
    $mbbank->user = htmlspecialchars($UserMB, ENT_QUOTES, 'UTF-8');
    $mbbank->pass = htmlspecialchars($PassMB, ENT_QUOTES, 'UTF-8');
    return json_decode($mbbank->login($captcha), true);
}

function getTransactionHistory($mbbank, $UserMB, $_SessionID, $deviceId, $StkMB)
{
    return $mbbank->get_lsgd($UserMB, $_SessionID, $deviceId, $StkMB, 2);
}

$captcha_type = '2024';
$captcha = getCaptcha($mbbank, $captcha_type);

if (empty($UserMB) || empty($PassMB) || empty($StkMB)) {
    exit(json_encode(array('status' => '1', 'msg' => 'Vui lòng điền đầy đủ thông tin')));
}

$login = loginMBBank($mbbank, $UserMB, $PassMB, $captcha);

if (isset($login['result']['message'])) {
    if ($login['result']['message'] == "Capcha code is invalid") {
        exit(json_encode(array('status' => '1', 'msg' => 'Captcha không chính xác')));
    } elseif ($login['result']['message'] == 'Customer is invalid') {
        exit(json_encode(array('status' => '1', 'msg' => 'Thông tin không chính xác')));
    } else {
        if (isset($login['sessionId']) && isset($login['cust']['softTokenList'][0]['deviceId'])) {
            $sessionIdc = $login['sessionId'];
            $deviceId = $login['cust']['softTokenList'][0]['deviceId'];
            $file_content = "$mbbank->deviceIdCommon_goc|$sessionIdc";
            $ImSynZx = tempnam(sys_get_temp_dir(), 'mbbank_');
            file_put_contents($ImSynZx, $file_content);
            $file_content = file_get_contents($ImSynZx);
            $_InfoCheck = explode("|", $file_content);
            $_DeviceID = $_InfoCheck[0];
            $_SessionID = $_InfoCheck[1];
            unlink($ImSynZx);
            $SynZx_Check = getTransactionHistory($mbbank, $UserMB, $_SessionID, $_DeviceID, $StkMB);
            $SynZx_Check1 = json_decode($SynZx_Check, true);
            if (isset($SynZx_Check1['result']['message']) && $SynZx_Check1['result']['message'] == 'Success') {
                $transactions = $SynZx_Check1['transactionHistoryList'] ?? [];
                if (!is_array($transactions)) {
                    exit(json_encode(array('status' => '1', 'msg' => 'Dữ liệu lịch sử giao dịch không hợp lệ')));
                }
				//echo $SynZx_Check;
                foreach ($transactions as $transaction) {
                   // if (isset($transaction['description']) && strpos($transaction['description'], 'naptien') !== false) {
                    //    $pos = strpos($transaction['description'], 'naptien') + strlen('naptien');
					if (isset($transaction['description']) && stripos($transaction['description'], 'naptien') !== false) {
                        $pos = stripos($transaction['description'], 'naptien') + strlen('naptien');
                        $refNo = $transaction['refNo'];
                        $ID = trim(explode(' ', substr($transaction['description'], $pos))[0]);
                        $stmt_check_refNo = $conn->prepare("SELECT COUNT(*) FROM payments WHERE refNo = :refNo");
                        $stmt_check_refNo->bindParam(':refNo', $refNo, PDO::PARAM_STR);
                        $stmt_check_refNo->execute();
                        $count = $stmt_check_refNo->fetchColumn();
                        if ($count > 0) {
                            continue;
                        }
                        $stmt_account = $conn->prepare("SELECT * FROM account WHERE id = :ID");
                        $stmt_account->bindParam(':ID', $ID, PDO::PARAM_STR);
                        $stmt_account->execute();
                        $account = $stmt_account->fetch(PDO::FETCH_ASSOC);
                        if ($account) {
                            $amount = htmlspecialchars($transaction['creditAmount'], ENT_QUOTES, 'UTF-8');
                            try {
                                $conn->beginTransaction();
                                $TotalAccount = $conn->prepare("UPDATE account SET vnd = vnd + :amount, tongnap = tongnap + :amount WHERE id = :id");
                                $TotalAccount->bindParam(':amount', $amount, PDO::PARAM_STR);
                                $TotalAccount->bindParam(':id', $account['id'], PDO::PARAM_INT);
                                $TotalAccount->execute();
                                $PaymentUpdate = $conn->prepare("INSERT INTO payments (name, refNo, date, amount, status, bank) VALUES (:name, :refNo, NOW(), :amount, 'Thành Công', 'Ngân Hàng Quân Đội MBBank')");
                                $PaymentUpdate->bindParam(':name', $ID, PDO::PARAM_STR);
                                $PaymentUpdate->bindParam(':refNo', $refNo, PDO::PARAM_STR);
                                $PaymentUpdate->bindParam(':amount', $amount, PDO::PARAM_STR);
                                $PaymentUpdate->execute();
                                $conn->commit();
                            } catch (Exception $e) {
                                $conn->rollBack();
                                echo "Failed to update account and insert payment: " . $e->getMessage();
                            }
                        } else {
                            echo "Không tìm thấy tài khoản phù hợp với ID: $ID<br>";
                        }
                    }
                }
            } else {
                exit($SynZx_Check);
            }
        } else {
            exit("Dữ liệu trả về từ MBBank API không hợp lệ");
        }
    }
} else {
    exit("Không có thông tin trả về từ MBBank API");
}
?>
