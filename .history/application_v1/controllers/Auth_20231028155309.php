<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Esmaeeli\Jwt\Generator;
use Esmaeeli\Jwt\Parser;
use Esmaeeli\Jwt\Cryptography\Algorithms\Hmac\HS256;
use Esmaeeli\Jwt\Exceptions\ValidationException;
use Esmaeeli\Jwt\Validator\DefaultValidator;
use Esmaeeli\Jwt\Validator\Rules\EqualsTo;
use Esmaeeli\Jwt\Validator\Rules\NewerThan;
class Auth extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		$this->load->helper('captcha');
	}
	public function index(){
		$this->load->view('welcome_message');
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
