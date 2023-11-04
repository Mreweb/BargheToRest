<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Bills extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct() {
        parent::__construct(); 
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
    }

    public function get_list() {
        if (check_request_method('GET')) { 
            $inputs = $this->input->get(); 
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelProfile->get_user_bill_list($inputs);
            response(get_req_message('SuccessAction', null , $result), 200);
            
        }

    }
    public function add_bill() {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillTitle', 'عنوان قبض', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputBillNumberID', 'شناسه قبض', 'trim|required|numeric|min_length[2]|max_length[50]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProfile->do_add_bill($inputs);
                response($result, 200);
                die();
            }
        }

    }
    public function change_user_legal_info()
    {


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
            /* Log Action */
            if ($result['success']) {
                $logArray = getVisitorInfo();
                $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
                $logArray['Description'] = json_encode($inputs);
                $logArray['LogPersonId'] = $this->loginInfo['Info']['PersonId'];
                $this->ModelLog->doAdd($logArray);
            }
            /* End Log Action */
        }

    }
    
}