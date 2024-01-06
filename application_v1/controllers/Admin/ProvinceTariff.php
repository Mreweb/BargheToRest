<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class ProvinceTariff extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){
        parent::__construct();
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelProvince');
    }
    public function index(){
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->get_list();
                break;
            case 'POST':
                $this->add_province_tariff();
                break;
            case 'PUT':
                $this->edit_province_tariff();
                break;
            case 'DELETE':
                $this->delete_province_tariff();
                break;
            default:
                check_request_method('NONE');
                break;
        }
    }
    public function get_list(){
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $result = $this->ModelProvince->get_province_tariff_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function add_province_tariff(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputProvinceId', 'شناسه استان', 'trim|required'); 
            $this->form_validation->set_rules('inputLowPowerFromHour', 'ساعت کم باری از', 'trim|required'); 
            $this->form_validation->set_rules('inputLowPowerToHour', 'ساعت کم باری تا', 'trim|required'); 
            $this->form_validation->set_rules('inputMiddlePowerFromHour', 'ساعت میان باری از', 'trim|required'); 
            $this->form_validation->set_rules('inputMiddlePowerToHour', 'ساعت میان باری تا', 'trim|required'); 
            $this->form_validation->set_rules('inputPeakPowerFromHour', 'ساعت اوج باری از', 'trim|required'); 
            $this->form_validation->set_rules('inputPeakPowerToHour', 'ساعت اوج باری تا', 'trim|required'); 
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProvince->do_add_province_tariff($inputs);
                response($result, 200);
                die();
            }
        }

    }
    public function edit_province_tariff()
    {
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputProvinceTariffId', 'شناسه تعرفه', 'trim|required'); 
            $this->form_validation->set_rules('inputLowPowerFromHour', 'ساعت کم باری از', 'trim|required'); 
            $this->form_validation->set_rules('inputLowPowerToHour', 'ساعت کم باری تا', 'trim|required'); 
            $this->form_validation->set_rules('inputMiddlePowerFromHour', 'ساعت میان باری از', 'trim|required'); 
            $this->form_validation->set_rules('inputMiddlePowerToHour', 'ساعت میان باری تا', 'trim|required'); 
            $this->form_validation->set_rules('inputPeakPowerFromHour', 'ساعت اوج باری از', 'trim|required'); 
            $this->form_validation->set_rules('inputPeakPowerToHour', 'ساعت اوج باری تا', 'trim|required'); 
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProvince->do_edit_province_tariff($inputs);
                response($result, 200);
                die();
            }
        }

    }
    public function delete_province_tariff()
    {
        if (check_request_method('DELETE')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelProvince->do_delete_province_tariff($inputs);
            response($result, 200);
            die();
        }
    } 

    public function add_electricity_price(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelProvince->do_add_electricity_price($inputs);
            response($result, 200);
            die();
        }
    } 

    public function do_update_electricity_green_price(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelProvince->do_update_electricity_green_price($inputs);
            response($result, 200);
            die();
        }
    } 

    
    public function get_electricity_price(){
        if (check_request_method('GET')) { 
            $result = $this->ModelProvince->get_electricity_price();
            response($result, 200);
            die();
        }
    } 

    public function get_electricity_green_price(){
        if (check_request_method('GET')) { 
            $result = $this->ModelProvince->get_electricity_green_price();
            response($result, 200);
            die();
        }
    } 
    
    

}