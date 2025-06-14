<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';

require './vendor/autoload.php';
use Gregwar\Captcha\CaptchaBuilder;

class GetCaptchaNew extends CI_Controller
{
  public function index()
  {
    if (check_request_method('GET')) {

      $random_alpha = mb_strtoupper(rand(11111, 99999));
      $builder = new CaptchaBuilder($random_alpha);
      $builder->build(200,50); 
      $this->session->set_userdata('CaptchaCode',  $builder->getPhrase()); 

      /*$data['content'] = array(
        'captchaImage' => $builder->inline(),
        'success'=> true,
        'code' => $builder->getPhrase()
      );*/
      $data['content'] = array(
        'captchaImage' => $builder->inline(),
        'success'=> true
      );
      echo json_encode($data, JSON_UNESCAPED_SLASHES);

      /*$random_alpha = mb_strtoupper(rand(11111, 99999));
      $captcha_code = substr($random_alpha, 0, 5);
      $this->session->set_userdata('CaptchaCode', $captcha_code);
      $target_layer = imagecreatetruecolor(100, 50);
      $captcha_background = imagecolorallocate($target_layer, 0, 0, 0);
      imagefill($target_layer, 0, 0, $captcha_background);
      $captcha_text_color = imagecolorallocate($target_layer, 255, 255, 255);
      imagestring($target_layer, 5, 30, 18, $captcha_code, $captcha_text_color);
      ob_start();
      imagejpeg($target_layer);
      $target_layer = ob_get_clean();
      ob_end_clean();
      $data['content'] = array(
        'captchaImage' => "data:image/png;base64,".base64_encode($target_layer),
        'success'=> true,
        'code' => $captcha_code
      );
      echo json_encode($data);
    } else{
      response(get_req_message('MethodNotAllowed'), 405);
    }*/
    }
  }
}

?>