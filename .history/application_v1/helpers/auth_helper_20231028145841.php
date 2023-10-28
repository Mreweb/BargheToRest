<?php
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Validator\DefaultValidator;
use MiladRahimi\Jwt\Validator\Rules\EqualsTo;
use MiladRahimi\Jwt\Validator\Rules\NewerThan;
function checkToken(){
    require 'vendor/autoload.php';
    $ci =& get_instance();
    $headers = $ci->input->request_headers(); 
    if (isset($headers['authorization'])) {
        $jwt = $headers['authorization'];
        if ($jwt == null | $jwt == '') {
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['success' => false, 'message' => 'Invalid Token']);
            die();
        }
    } else {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode([ 'success' => false,  'message' => 'your token has expired' ]);
        die();
    }
    $jwt = str_ireplace("Bearer ", "", $jwt);
    $signer = new HS256($ci->config->item('HS256KEY'));
    $validator = new DefaultValidator();
    $validator->addRule('is-admin', new EqualsTo(true));
    $validator->addRule('expire_time', new NewerThan(time()));
    try {
        $parser = new Parser($signer, $validator);
        $claims = $parser->parse($jwt);
        var_dump($claims);
    } catch (ValidationException $e) {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode([
            'success' => false,
            'message' => 'your token has expired'
        ]);
    }
}
function getTokenInfo(){
    require 'vendor/autoload.php';
    $ci =& get_instance();
    $headers = $ci->input->request_headers();
    $jwt = $headers['authorization'];
    $jwt = str_ireplace("Bearer ", "", $jwt);
    $signer = new HS256($ci->config->item('HS256KEY'));
    $parser = new Parser($signer);
    return $parser->parse($jwt);
}
