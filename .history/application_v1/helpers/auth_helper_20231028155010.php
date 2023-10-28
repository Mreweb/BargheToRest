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
            response([
                'code' => 'SERVICE.INVALIDTOKEN',
                'success' => false,
                'message' => 'درخواست نامعتبر است'
            ], 401);
            die();
        }
    } else {
        response([
            'code' => 'SERVICE.NOTFOUNDTOKEN',
            'success' => false,
            'message' => 'درخواست منقضی شده است'
        ], 401);
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
        $data['content'] = $claims;
        response([
            'data' => $data,
            'success' => true,
            'message' => 'درخواست با موفقیت انجام شد'
        ], 200);
    } catch (Exception $e) {
        response([
            'code' => 'SERVICE.INVALIDTOKEN',
            'success' => false,
            'message' => 'درخواست نامعتبر است'
        ], 401);
        die();
    } 

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
        $claims = $parser->parse($jwt);
        $data['content'] = $claims;
        response([
            'data' => data,
            'success' => true,
            'message' => 'درخواست با موفقیت انجام شد'
        ], 200);
    } catch (Exception $e) {
        response([
            'code' => 'SERVICE.INVALIDTOKEN',
            'success' => false,
            'message' => 'invalidToken'
        ], 200);
    }
}
