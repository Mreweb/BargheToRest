<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Account extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('ModelAccount');
    }
    public function auto() {
    }
    public function index() {
        //slient
    }
    public function submit_phone(){
        $inputs = json_decode($this->input->raw_input_stream, true);
        $inputs = custom_filter_input($inputs);
        if (check_request_method('POST')) {
            check_captcha($inputs); 
            /* Validate Comming Data */
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPhone', 'تلفن همراه', 'trim|required|min_length[11]|max_length[13]');
            $this->form_validation->set_rules('inputCaptchaCode', 'کد امنیتی', 'trim|required|exact_length[5]');
            $this->form_validation->set_rules('inputCaptchaId', 'شناسه کد امنیتی', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
            } else {
                $result = $this->ModelAccount->do_submit_phone($inputs);
                response($result, 200);
            }
        }
    }
    public function verify_phone(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $result = $this->ModelAccount->do_verify_phone($inputs);
            response($result, 200);
        }
    }

}
