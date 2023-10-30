<?php
defined('BASEPATH') or exit('No direct script access allowed');
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Validator\DefaultValidator;
use MiladRahimi\Jwt\Validator\Rules\EqualsTo;
use MiladRahimi\Jwt\Validator\Rules\NewerThan;
class Auth extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		$this->load->helper('captcha');
	}
	public function index(){
		//slient
	}
	public function generate(){
		require 'vendor/autoload.php';
		$signer = new HS256($this->config->item('HS256KEY'));
		$generator = new Generator($signer);
		$jwt = $generator->generate([
            'id' => 666,
            'is-admin' => true ,
            'roles' => ['ADMIN' , 'AGENCY'] ,
            'expire_time' =>time()+200
        ]);
		response([
			'success' => true,
			'message' => 'دریافت شناسه با موفقیت انجام شد',
			'token' => $jwt
		], 200);
	}
	public function is_ok(){
		checkToken();
	}
	public function get_info(){
		$info = getTokenInfo();
		print_r($info);
	}
}
