<?php
class ModelCrawl extends CI_Model{
    public function get_list($inputs){
        $this->db->select('Token'); 
        $this->db->from('crawl_token');
        $this->db->order_by('TokenId' , 'DESC');
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query[0];
        $result['data']['count'] = 1;
        return $result;
    }
    public function add_token($inputs){ 
        $userArray = array(
            'Token' => $inputs['inputToken'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $inserId = $this->db->insert('crawl_token', $userArray);
        if ($inserId > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
}
?>