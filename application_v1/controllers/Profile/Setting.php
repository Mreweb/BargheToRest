<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Setting extends CI_Controller
{
    private $loginInfo;
    private $enum;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelAccount');
        $this->load->model('ModelCountry');
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
    }
    public function change_user_info(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputFirstName', 'نام', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputLastName', 'نام خانوادگی', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputNationalCode', 'کد ملی', 'trim|required|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('inputAddress', 'آدرس ', 'trim|required|min_length[5]|max_length[150]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProfile->do_change_info($inputs);
                response($result, 200);
                die();
            }
        }
    }
    public function change_user_legal_info(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputLegalOrganizationName', 'نام سازمان', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputLegalFinanceCode', 'کد اقتصادی', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputLegalCompanyId', 'شناسه ملی', 'trim|required|min_length[1]|max_length[50]');
            $this->form_validation->set_rules('inputLegalRegisterNumber', 'شناسه ثبت', 'trim|required|min_length[1]|max_length[50]');
            $this->form_validation->set_rules('inputLegalPhone', 'تلفن ثابت دفتر مرکزی', 'trim|required|min_length[4]|max_length[50]');
            $this->form_validation->set_rules('inputLegalProvinceId', 'استان', 'trim|required|numeric');
            $this->form_validation->set_rules('inputLegalCityId', 'شهر', 'trim|required|numeric');
            $this->form_validation->set_rules('inputLegalAddress', 'آدرس', 'trim|required|min_length[5]|max_length[150]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProfile->do_change_user_legal_info($inputs);
                response($result, 200);
                die();
            }
        }
    }
    
    public function submit_new_phone(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPhone', 'تلفن همراه', 'trim|required|min_length[11]|max_length[13]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProfile->do_submit_new_phone($inputs);
                response($result, 200);
                die();
            }
        }
    }
    public function verify_new_phone(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputVerifyCode', 'کد تایید', 'trim|required|min_length[4]|max_length[4]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProfile->do_verify_new_phone($inputs);
                response($result, 200);
                die();
            }
        }
    }


    public function get_user_info(){
        if (check_request_method('GET')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelPerson->get_person_all_info_by_person_id( $inputs['inputPersonId']);
            response($result, 200);
        }
    }


}