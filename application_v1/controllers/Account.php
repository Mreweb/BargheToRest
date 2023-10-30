<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelAccount');
    }
    public function auto()
    {
        /*$this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonPhone' => '09120572107'));
        $query = $this->db->get();
        $this->session->set_userdata('LoginInfo' , $query->result_array()[0]);
        $this->session->set_userdata('IsLogged' , TRUE);*/
    }
    public function index()
    {
        //slient
    }
    public function submit_phone() {
        $inputs = json_decode($this->input->raw_input_stream, true);
        $inputs = custom_filter_input($inputs);
        /* Check Request Method */
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            /* Validate Comming Data */
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPhone', 'تلفن همراه', 'trim|required|min_length[11]|max_length[13]');
            $this->form_validation->set_rules('inputCaptcha', 'کد امنیتی', 'trim|required|exact_length[5]');
            if ($this->form_validation->run() == FALSE){
                response(get_req_message('ErrorAction' , validation_errors() ), 400 );
            }
            else{
                $result = $this->ModelAccount->do_submit_phone($inputs);
                response($result, 200 ); 
            }
        } else{
            response(get_req_message('MethodNotAllowed'), 405 );
        }
    }
    public function verify_phone() {
        $inputs = json_decode($this->input->raw_input_stream, true);
        $inputs = custom_filter_input($inputs);
        $result = $this->ModelAccount->do_verify_phone($inputs);
        /* Log Action */
        /*if ($result['success']) {
            $logArray = getVisitorInfo();
            $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
            $logArray['Description'] = json_encode($inputs);
            $logArray['LogPersonId'] = $result['personId'];
            $this->ModelLog->doAdd($logArray);
            $this->session->unset_userdata('PersonPhone');
        }*/
        /* End Log Action */
        response($result , 200 );
 
    }

}
