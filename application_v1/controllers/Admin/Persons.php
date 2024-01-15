<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Persons extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){  
        parent::__construct();
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
        $this->load->model('ModelPerson');
        $this->load->model('Admin/ModelBill');
        $this->load->model('Admin/ModelFinance');
    }
    public function index(){
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->get_list();
                break;
            case 'POST':
                //$this->add_bill();
                break;
            case 'PUT':
                //$this->edit_bill();
                break;
            case 'DELETE':
                //$this->delete_bill();
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
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelPerson->get_persons_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }

    public function get_person_detail($personId){
        if (check_request_method('GET')) {  
            $result = $this->ModelPerson->get_person_detail($personId);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }

    public function get_person_bills($personId){
        if (check_request_method('GET')) {  
            $inputs['inputPersonId'] = $personId;
            $result = $this->ModelBill->get_user_all_bill_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }

    public function get_person_orders($personId){
        if (check_request_method('GET')) {  
            $inputs['inputPersonId'] = $personId;
            $result = $this->ModelFinance->get_user_all_orders($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    

}