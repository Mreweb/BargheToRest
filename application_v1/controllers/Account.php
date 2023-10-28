<?php
defined('BASEPATH') OR exit('No direct script access allowed');


include APPPATH.'helpers/cors.php';


class Account extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('ModelAccount');
    }
    public function auto(){
        /*$this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonPhone' => '09120572107'));
        $query = $this->db->get();
        $this->session->set_userdata('LoginInfo' , $query->result_array()[0]);
        $this->session->set_userdata('IsLogged' , TRUE);*/
    }
	public function index(){}
    public function submit_phone(){
		$json = file_get_contents('php://input');
		$inputs = json_decode($json, true);
		var_dump($inputs);
        $inputs = array_map(function ($v) {
            return strip_tags($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return remove_invisible_characters($v);
        }, $inputs);
        $inputs = mapArray('makeSafeInput' , $inputs);
        //$result = $this->ModelAccount->doSubmitPhone($inputs);
        echo json_encode($inputs);
    }
    public function verify_phone(){
        $inputs = $this->input->post(NULL, TRUE);
        $inputs = array_map(function ($v) {
            return strip_tags($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return remove_invisible_characters($v);
        }, $inputs);
        $inputs = mapArray('makeSafeInput' , $inputs);
       if ($this->session->userdata('CSRF') !== $inputs['inputCSRF']) {
            $arr = array(
                'type' => "red",
                'content' => "درخواست نامعتبر است"
            );
            echo json_encode($arr);
            die();
        }
        $inputs['inputPhone'] = $this->session->userdata('PersonPhone');
        $result = $this->ModelAccount->doVerifyPhone($inputs);

        /* Log Action */
        if($result['success']) {
            $logArray = getVisitorInfo();
            $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
            $logArray['Description'] = json_encode($inputs);
            $logArray['LogPersonId'] = $result['personId'];
            $this->ModelLog->doAdd($logArray);
            $this->session->unset_userdata('PersonPhone');
        }
        /* End Log Action */

        echo json_encode($result);
    }

}
