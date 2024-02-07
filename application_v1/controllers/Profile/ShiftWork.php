<?php            
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class ShiftWork extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){
        parent::__construct();
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelShiftWork');
    }

    public function index(){ 
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->get_shift_work_list();
                break;
            case 'POST':
                $this->add_shift_work();
                break;
            case 'PUT':
                //$this->edit_whift_work();
                break;
            case 'DELETE': 
                $this->delete_shift_work();
                break;
            default:
                check_request_method('NONE');
                break;
        }
    }
    public function get_shift_work_list(){
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelShiftWork->get_shift_work_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function add_shift_work() {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true); 
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputShiftWorkTitle', 'عنوان شیفت کاری', 'trim|required|min_length[2]|max_length[80]');
            $this->form_validation->set_rules('inputShiftWorkFromDate', 'بازه شروع شیفت کاری', 'trim|required');
            $this->form_validation->set_rules('inputShiftWorkToDate', 'بازه پایان شیفت کاری', 'trim|required');
            $this->form_validation->set_rules('inputShiftWorkDays[]', 'شیفت های کاری', 'required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelShiftWork->do_add_shift_work($inputs);
                response($result, 200);
                die();
            }
        }
    }
    public function delete_shift_work(){
        if (check_request_method('DELETE')) {
            $inputs = json_decode($this->input->raw_input_stream, true); 
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
             $result = $this->ModelShiftWork->do_delete_shift_work($inputs);
            response($result, 200);
            die();
        }
    }

    
    public function get_shift_work($shiftWorkId){
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelShiftWork->get_shift_work($shiftWorkId);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }

}