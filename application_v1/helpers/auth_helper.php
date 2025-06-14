<?php
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Validator\DefaultValidator;
use MiladRahimi\Jwt\Validator\Rules\EqualsTo;
use MiladRahimi\Jwt\Validator\Rules\NewerThan;
function getTokenInfo($return = false , $role=null){
    require 'vendor/autoload.php';
    $ci =& get_instance();
    $headers = $ci->input->request_headers(); 
    if (isset($headers['authorization']) || isset($headers['Authorization'])) {
        $jwt = $headers['authorization'];
        if($jwt == null){
            $jwt = $headers['Authorization'];
        }
        if ($jwt == null | $jwt == '') {
            response([
                'code' => 'SERVICE.INVALIDTOKEN',
                'success' => false,
                'message' => 'درخواست نامعتبر است'
            ], 401);
            die();
        }
    }
     else {
        response([
            'code' => 'SERVICE.NOTFOUNDTOKEN',
            'success' => false,
            'message' => 'توکن احراز هویت یافت نشد'
        ], 401);
        die();
    }
    $jwt = $headers['authorization'];
        if($jwt == null){
            $jwt = $headers['Authorization'];
        }
    $jwt = str_ireplace("Bearer ", "", $jwt);
    $signer = new HS256($ci->config->item('HS256KEY'));
    try {
        $parser = new Parser($signer);
        $claims = $parser->parse($jwt);
 
        if($role != null){
            if($claims['Info']['PersonType'] != $role){
                response([
                    'code' => 'SERVICE.INVALIDTOKEN',
                    'success' => false,
                    'message' => 'احراز نامعتبر است'
                ], 401);
                die();
            }
        }
        /*if(time() > $claims['expire_time']){
            response([
                'code' => 'SERVICE.EXPIRED',
                'success' => false,
                'message' => 'توکن منقضی شده است'
            ], 401);
            die();
        }*/
        if($return){
            return $claims;
        } else{
            response($claims, 200);
        }
    } catch (Exception $e) {
        response([
            'code' => 'SERVICE.INVALIDTOKEN',
            'success' => false,
            'message' => 'درخواست نامعتبر است'
        ], 401);
        die();
    }
}