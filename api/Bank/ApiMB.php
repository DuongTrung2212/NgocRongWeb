<?php
class MBBANK
{

    public $user = '';
    public $pass = '';
    public $deviceIdCommon_goc = '';
    public $proxy = '';
    public function get_captcha()
    {


        $url = 'https://online.mbbank.com.vn/api/retail-web-internetbankingms/getCaptchaImage';

        $headers = [
            'Accept: application/json, text/plain, */*',
            'Accept-Language: vi-VN,vi;q=0.9',
            'Authorization: Basic RU1CUkVUQUlMV0VCOlNEMjM0ZGZnMzQlI0BGR0AzNHNmc2RmNDU4NDNm',
            'Connection: keep-alive',
            'Content-Length: 103',
            'Content-Type: application/json; charset=UTF-8',
            'Deviceid: a6g4emzh-mbib-0000-0000-2024061109201987',
            'Elastic-Apm-Traceparent: 00-c2edac90a34e1fc1ec09c4bee77d5d46-4011fc9eeb97efc9-01',
            'Host: online.mbbank.com.vn',
            'Origin: https://online.mbbank.com.vn',
            'Referer: https://online.mbbank.com.vn/pl/login?returnUrl=%2F',
            'Refno: 2024061109363141',
            'Sec-Ch-Ua: "Google Chrome";v="125", "Chromium";v="125", "Not.A/Brand";v="24"',
            'Sec-Ch-Ua-Mobile: ?0',
            'Sec-Ch-Ua-Platform: "Windows"',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36',
            'X-Request-Id: 2024061109363141'
        ];

        $payload = '{
            "refNo" : "' . date("Ymd") . '09201987",
            "deviceIdCommon" : "' . $this->deviceIdCommon_goc . '",
            "sessionId" : ""
          }';
        $payload = json_encode([
            'refNo' => '2024061109403157',
            'deviceIdCommon' => 'a6g4emzh-mbib-0000-0000-2024061109201987',
            'sessionId' => ''
        ]);
        $payload = json_encode([
            'refNo' => date("Ymd") . '09201987',
            'deviceIdCommon' => $this->deviceIdCommon_goc,
            'sessionId' => ''
        ]);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        if (!empty($this->proxy)) {
            $proxy = explode(":", $this->proxy);
            $opt = array(
                CURLOPT_PROXY => $proxy[0] . ":" . $proxy[1],
                CURLOPT_PROXYUSERPWD => $proxy[2] . ":" . $proxy[3],
                CURLOPT_TIMEOUT => 5,
            );
            curl_setopt_array($ch, $opt);
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $response;

    }
    public function login($captcha)
    {
        $header = array(
            'Accept: application/json, text/plain, */*',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: en-US,en;q=0.9,vi;q=0.8',
            'Authorization: Basic QURNSU46QURNSU4=',
            'Connection: keep-alive',
            'Content-Type: application/json; charset=UTF-8',
            'elastic-apm-traceparent: 00-17620ad87b0b1e04da1d1cf8e8d8c287-bfd8deead47f0f3c-01',
            'Host: online.mbbank.com.vn',
            'Origin: https://online.mbbank.com.vn',
            'Referer: https://online.mbbank.com.vn/pl/login?logout=1',
            'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36',
            'X-Request-Id: 7ed665bc35bb47f19b263447bd1cc180-2022090511445886',
        );
        $Action = 'https://online.mbbank.com.vn/retail_web/internetbanking/doLogin';
        $Data = '{
            "password" : "' . $this->pass . '",
            "refNo" : "' . md5($this->user) . '-' . date('YmdHis') . '",
            "sessionId" : null,
            "userId" : "' . $this->user . '",
            "captcha" : "' . $captcha . '",
            "deviceIdCommon" : "' . $this->deviceIdCommon_goc . '"
          }';
        $result = $this->CURL2($Action, $header, $Data);
        return $result;
    }


    public function get_lsgd($user, $session_id, $deviceId, $account, $day)
    {


        $curl = curl_init();
        if (!empty($this->proxy)) {
            $proxy = explode(":", $this->proxy);
            $opt = array(
                CURLOPT_PROXY => $proxy[0] . ":" . $proxy[1],
                CURLOPT_PROXYUSERPWD => $proxy[2] . ":" . $proxy[3],
                CURLOPT_TIMEOUT => 5,
            );
            curl_setopt_array($curl, $opt);
        }
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://online.mbbank.com.vn/api/retail-transactionms/transactionms/get-account-transaction-history',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
            "toDate" : "' . date("d/m/Y") . '",
            "accountNo" : "' . $account . '",
            "sessionId" : "' . $session_id . '",
            "fromDate" : "' . date("d/m/Y", strtotime("$day days ago")) . '",
            "refNo" : "' . $user . '-' . date('YmdHis') . '",
            "deviceIdCommon" : "' . $deviceId . '"
          }',
                CURLOPT_HTTPHEADER => array(
                    'Deviceid: ' . $deviceId . '',
                    'sec-ch-ua: "Not_A Brand";v="8", "Chromium";v="120", "Google Chrome";v="120"',
                    'sec-ch-ua-mobile: ?0',
                    'Authorization: Basic RU1CUkVUQUlMV0VCOlNEMjM0ZGZnMzQlI0BGR0AzNHNmc2RmNDU4NDNm',
                    'elastic-apm-traceparent: 00-690e238f5a479be690001e5257478972-4b8184bf0f444db1-01',
                    'Content-Type: application/json; charset=UTF-8',
                    'RefNo: 0978364572-2024011200141777',
                    'Accept: application/json, text/plain, */*',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Referer: https://online.mbbank.com.vn/information-account/source-account',
                    'X-Request-Id: ' . $user . '-' . date('YmdHis') . '',
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function get_lsgd2($user, $session_id, $deviceId, $account, $day)
    {
        $header = array(
            'Accept: application/json, text/plain, */*',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: en-US,en;q=0.9,vi;q=0.8',
            'Authorization: Basic QURNSU46QURNSU4=',
            'Connection: keep-alive',
            'Content-Type: application/json; charset=UTF-8',
            'elastic-apm-traceparent: 00-17620ad87b0b1e04da1d1cf8e8d8c287-bfd8deead47f0f3c-01',
            'Host: online.mbbank.com.vn',
            'Origin: https://online.mbbank.com.vn',
            'Referer: https://online.mbbank.com.vn/information-account/source-account',
            'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36',
            'X-Request-Id: ' . $user . '-' . date('YmdHis') . '',
        );
        $Action = 'https://online.mbbank.com.vn/api/retail-web-transactionservice/transaction/getTransactionAccountHistory';
        $Data = json_encode([
            'toDate' => date("d/m/Y"),
            'accountNo' => $account,
            'historyNumber' => '',
            'sessionId' => $session_id,
            'fromDate' => date("d/m/Y", strtotime("$day days ago")),
            'refNo' => $user . '-' . date('YmdHis'),
            'deviceIdCommon' => $deviceId
        ]);

        $result = $this->CURL2($Action, $header, $Data);
        return $result;
    }

    public function get_balance($account, $session_id, $deviceId)
    {
        $header = array(
            'Accept: application/json, text/plain, */*',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: en-US,en;q=0.9,vi;q=0.8',
            'Authorization: Basic QURNSU46QURNSU4=',
            'Connection: keep-alive',
            'Content-Type: application/json; charset=UTF-8',
            'elastic-apm-traceparent: 00-17620ad87b0b1e04da1d1cf8e8d8c287-bfd8deead47f0f3c-01',
            'Host: online.mbbank.com.vn',
            'Origin: https://online.mbbank.com.vn',
            'Referer: https://online.mbbank.com.vn/information-account/source-account',
            'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36',
            'X-Request-Id: 7ed665bc35bb47f19b263447bd1cc180-2022090511445886',
        );
        $Action = 'https://online.mbbank.com.vn/retail-web-accountms/getBalance';
        $Data = '{
            "refNo" : "' . $account . '-' . date('YmdHis') . '",
            "sessionId" : "' . $session_id . '",
            "deviceIdCommon" : "' . $deviceId . '"
          }';
        $result = $this->CURL2($Action, $header, $Data);
        return $result;
    }
    public function CURL2($Action, $header, $data)
    {
        $curl = curl_init();
        $opt = array(
            CURLOPT_URL => $Action,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => empty($data) ? false : true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_CUSTOMREQUEST => empty($data) ? 'GET' : 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_HEADER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2,
            CURLOPT_TIMEOUT => 5,
        );
        curl_setopt_array($curl, $opt);
        if (!empty($this->proxy)) {
            $proxy = explode(":", $this->proxy);
            $opt2 = array(
                CURLOPT_PROXY => $proxy[0] . ":" . $proxy[1],
                CURLOPT_PROXYUSERPWD => $proxy[2] . ":" . $proxy[3],
                CURLOPT_TIMEOUT => 5,
            );
            curl_setopt_array($curl, $opt2);
        }
        $body = curl_exec($curl);

        return $body;
    }


    private function CURL($Action, $header, $data)
    {
        $Data = is_array($data) ? json_encode($data) : $data;
        $curl = curl_init();
        $header[] = 'Content-Type: application/json; charset=utf-8';
        $header[] = 'accept: application/json';
        $header[] = 'Content-Length: ' . strlen($Data);
        $opt = array(
            CURLOPT_URL => $this->URL[$Action],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => empty($data) ? false : true,
            CURLOPT_POSTFIELDS => $Data,
            CURLOPT_CUSTOMREQUEST => empty($data) ? 'GET' : 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_COOKIEJAR => "mb.txt",
            CURLOPT_COOKIEFILE => "mb.txt",
            CURLOPT_HEADER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 5,
        );
        curl_setopt_array($curl, $opt);
        $body = curl_exec($curl);
        if (is_object(json_decode($body))) {
            return json_decode($body, true);
        }
        return json_decode($body, true);
    }
    public function generateImei()
    {
        return $this->generateRandomString(8) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->get_time_request();
    }

    public function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function get_TOKEN()
    {
        return $this->generateRandomString(39);
    }
    public function get_time_request()
    {
        $d = getdate();
        $today = $d['hours'] . $d['minutes'] . $d['seconds'];
        $day = date('Y') . date('m') . date('d');
        return $day . $today;
    }
}