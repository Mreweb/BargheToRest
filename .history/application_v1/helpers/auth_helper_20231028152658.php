<?php
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Validator\DefaultValidator;
use MiladRahimi\Jwt\Validator\Rules\EqualsTo;
use MiladRahimi\Jwt\Validator\Rules\NewerThan;

function checkToken()
{
    require 'vendor/autoload.php';
    $ci =& get_instance();
    $headers = $ci->input->request_headers();
    if (isset($headers['authorization'])) {
        $jwt = $headers['authorization'];
        if ($jwt == null | $jwt == '') {
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode([
                'code' => 'SERVICE.INVALIDTOKEN',
                'success' => false,
                'message' => 'درخواست نامعتبر است'
            ]);
            die();
        }
    } else {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode([
            'code' => 'SERVICE.NOTFOUNDTOKEN',
            'success' => false,
            'message' => 'درخواست منقضی شده است'
        ]);
        die();
    }
    $jwt = str_ireplace("Bearer ", "", $jwt);
    $signer = new HS256($ci->config->item('HS256KEY'));
    $validator = new DefaultValidator();
    $validator->addRule('is-admin', new EqualsTo(true));
    $validator->addRule('expire_time', new NewerThan(time()));

    $parser = new Parser($signer, $validator);
    try {
        $claims = $parser->parse($jwt);
    } catch (ValidationException $e) {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode([
            'code' => 'SERVICE.INVALIDTOKEN',
            'success' => false,
            'message' => 'درخواست نامعتبر است'
        ]);
    }
    echo json_encode([
        'data' => $calims,
        'success' => true,
        'message' => 'درخواست با موفقیت انجام شد'
    ]);

}
function getTokenInfo()
{
    require 'vendor/autoload.php';
    $ci =& get_instance();
    $headers = $ci->input->request_headers();
    $jwt = $headers['authorization'];
    $jwt = str_ireplace("Bearer ", "", $jwt);
    $signer = new HS256($ci->config->item('HS256KEY'));
    try {
        $parser = new Parser($signer);
        return json_encode([
            'data' => $parser->parse($jwt),
            'success' => true,
            'message' => 'درخواست با موفقیت انجام شد'
        ]);
    } catch (Exception $e) {
        return json_encode([
            'code' => 'SERVICE.INVALIDTOKEN',
            'success' => false,
            'message' => 'invalidToken'
        ]);
    }
}
