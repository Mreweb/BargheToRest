<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Pay extends CI_Controller{ 
    public function __construct(){
        parent::__construct();
        $this->load->model('admin/ModelBill');
        $this->load->model('admin/ModelFinance');
        $this->load->model('ModelPerson');
        $this->load->model('admin/ModelProvince');
    }
    
    public function index(){
    }
    public function pay_result()
    {
        $this->load->view('pay');
    }

}