<?php
function pipeEnum($enumName, $k)
{
    $ci =& get_instance();
    foreach ($ci->config->item('Enum')[$enumName] as $key => $value) {
        if ($key == $k) {
            echo $value;
        }
    }
}
function FaToEn($input)
{
    return strtr($input, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
}
function convertDate($input, $isHtml = false , $format='Y/m/d')
{
    if ($input !== NULL) {
        if (!$isHtml) {
            return jDateTime::date($format, $input, false, true, 'Asia/Tehran');
        } else {
            return '<span style="direction:rtl;">' . jDateTime::date($format, $input, false, true, 'Asia/Tehran') . '</span>';
        }
    } else {
        return "";
    }
}

function convertTime($input, $isHtml = false)
{
    if ($input !== NULL) {
        if ($isHtml) {
            return jDateTime::date("H:i", $input, false, true, 'Asia/Tehran');
        } else {
            return '<span style="direction:rtl;">' . jDateTime::date("H:i:s", $input, false, true, 'Asia/Tehran') . '</span>';
        }
    } else {
        return "";
    }
}

function makeTimeFromDate($input)
{
    if ($input !== NULL) {
        $input = explode("/", $input);
        return jDateTime::mktime(0, 0, 0, $input[1], $input[2], $input[0]);
    }
}

function ping($host, $port, $timeout)
{

    $tB = microtime(true);
    $fP = fSockOpen($host, $port, $errno, $errstr, $timeout);
    if (!$fP) {
        return "down";
    }
    $tA = microtime(true);
    return round((($tA - $tB) * 1000), 0) . " ms";
}

function taxPrice($price)
{
    return round( ($price*0.09) , 2);
}

function getCurrentYear($increaseAmount = 0)
{
    return intval(jDateTime::date("Y", false, false, 'Asia/Tehran')) + $increaseAmount;
}

function isValidNationalCode($input)
{
    if (
        !preg_match("/^\d{10}$/", $input)
        || $input == '0000000000'
        || $input == '1111111111'
        || $input == '2222222222'
        || $input == '3333333333'
        || $input == '4444444444'
        || $input == '5555555555'
        || $input == '6666666666'
        || $input == '7777777777'
        || $input == '8888888888'
        || $input == '9999999999'
    ) {
        return false;
    }
    $check = (int) $input[9];
    $sum = array_sum(array_map(function ($x) use ($input) {
        return ((int) $input[$x]) * (10 - $x);
    }, range(0, 8))) % 11;
    return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
}

function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

function randomString($type = 'numeric', $length = 10)
{
    return random_string($type, $length);
}

function isSetValue($value)
{
    if (isset($value) && !empty($value) && trim($value) !== '') {
        return TRUE;
    }
    return FALSE;
}

function getSMSAPI()
{
    $ci =& get_instance();
    return $ci->config->item('SMSAPI');
}

function response($array, $code = null){
    if($code != null){
        http_response_code($code);
    } 
	header('Content-Type: application/json; charset=utf-8');
    echo json_encode($array, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES  );
}

function get_req_message($key , $custom_message = null , $additionalArray = array()){
    $ci =& get_instance();
    $msg = $ci->config->item('DBMessages')[$key];
    if($custom_message != null){
        $msg['message'] = $custom_message;
    }
    foreach($additionalArray as $key => $value){
        $msg[$key] = $value;
    }
    return $msg;
}

function check_request_method($method){
    $ci =& get_instance();
    if($method == $ci->input->server('REQUEST_METHOD')){
        return TRUE;
    }
    response(get_req_message('MethodNotAllowed'), 405);

}

function check_captcha($captcha){
    $ci =& get_instance();
    $data = $ci->db->select('*')->from('captcha')->where(array(
      'CaptchaId' => $captcha['inputCaptchaId'],
      'CaptchaCode' => $captcha['inputCaptchaCode'] 
    ))->get()->num_rows(); 
    if ($data <= 0) {
        response(get_req_message('ErrorAction', 'کد امنیتی صحیح نیست'), 400);
        die();
    }
}

function getVisitorInfo(){
    $ci =& get_instance();
    $data['IpAddress'] = $ci->input->ip_address();
    $data['Browser'] = $ci->agent->browser();
    $data['BrowserVersion'] = $ci->agent->version();
    $data['Platform'] = $ci->agent->platform();
    $data['FullUserAgentString'] = $_SERVER['HTTP_USER_AGENT'];
    return $data;
}


function sendSMS($method, $to, $inputs)
{

    //$to = '09120572107';
    if (sizeof($inputs) == 1) {
        $url = 'http://api.kavenegar.com/v1/' . getSMSAPI() . '/verify/lookup.json?receptor=' . $to . '&token=' . $inputs[0] . '&template=' . $method . '&type=sms';
    }
    if (sizeof($inputs) == 2) {
        $url = 'http://api.kavenegar.com/v1/' . getSMSAPI() . '/verify/lookup.json?receptor=' . $to . '&token=' . $inputs[0] . '&token2=' . $inputs[1] . '&template=' . $method . '&type=sms';
    }
    if (sizeof($inputs) == 3) {
        $url = 'http://api.kavenegar.com/v1/' . getSMSAPI() . '/verify/lookup.json?receptor=' . $to . '&token=' . $inputs[0] . '&token2=' . $inputs[1] . '&token3=' . $inputs[2] . '&template=' . $method . '&type=sms';
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_exec($curl);
    curl_close($curl);
}


?>