<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Upload extends CI_Controller{ 
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
    }
    public function file()
    {
        if (check_request_method('POST')) {


            $inputs = $this->input->post(NULL, TRUE);
            $uploadPath = base_url('uploads/');
            if (!empty($_FILES["file"])) {
                $myFile = $_FILES["file"];
                if ($myFile["error"] !== UPLOAD_ERR_OK) { 
                    response(get_req_message('ErrorAction', "خطای ارتباط با سرور"), 400);
                    die();
                }
                $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
                $i = 0;
                $parts = pathinfo($name);
                while (file_exists($uploadPath . $name)) {
                    $i++;
                    $name = $parts["filename"] . "_" . $i . "." . $parts["extension"];
                }
                if ($myFile['size'] > 20971520) { 
                    response(get_req_message('ErrorAction', "حجم فایل بیشتر از 20 مگابایت است"), 400);
                    die();
                }
                $allowedExtensions = array('jpg', 'png', 'gif', 'jpeg', 'zip', 'pdf', 'rar', 'doc', 'docx', 'xls', 'xlsx');
                $temp = explode(".", $myFile["name"]);
                $extension = strtolower(end($temp));
                if (!in_array($extension, $allowedExtensions)) { 
                    response(get_req_message('ErrorAction', "فرمت فایل ارسالی نامعتبر است"), 400); 
                    die();
                }
                $fileName = md5(rand(100, 9999) . microtime()) . '_' . randomString().".".$extension;
                $success = move_uploaded_file($myFile["tmp_name"],  $fileName);
                 if (!$success) { 
                    response(get_req_message('ErrorAction', "خطایی رخ داده است"), 400); 
                    die();
                } else {
                    chmod($uploadPath . $fileName, 0644); 
                    $this->db->insert('media' , array(
                        'Source' => base_url( $fileName) , 
                        'Extention' => $extension , 
                        'CreateDateTime' => time()
                    ));
                    response(get_req_message('ErrorAction', "بارگذاری با موفقیت انجام شد" , array( 'fileSrc' => base_url( $fileName))), 400); 
                    die();
                }
            } else {
                response(get_req_message('ErrorAction', "فایل ارسالی نامعتبر است"), 400); 
                die();
            }




            
        }
    }

}