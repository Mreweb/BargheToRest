<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Notification extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){
        parent::__construct(); 
        $this->loginInfo = getTokenInfo(true  , 'ADMIN'); 
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelNotification');
    }


    function _remap($param) {
        $this->index($param);
    }
    public function index($param=null){
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->get_list();
                break;
            case 'POST':
                $this->add_notification();
                break; 
            case 'PUT':
                $this->edit_notification();
                break; 
            case 'DELETE':
                $this->delete_notification($param);
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
            $result = $this->ModelNotification->get_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function add_notification(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputNotificationTitle', 'عنوان اعلان', 'trim|required'); 
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                
                $result = $this->ModelNotification->add_notification($inputs);
                response($result, 200);
                die();
            }
        }
    }

    public function edit_notification(){
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputNotificationTitle', 'عنوان اعلان', 'trim|required'); 
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                
                $result = $this->ModelNotification->edit_notification($inputs);
                response($result, 200);
                die();
            }
        }
    }

    public function delete_notification($param){
        if (check_request_method('DELETE')) { 
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputNotificationId'] = $param;
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputNotificationId', 'شناسه اعلان', 'trim|required'); 
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelNotification->delete_notification($inputs);
                response($result, 200);
                die();
            }
        }
    }

}