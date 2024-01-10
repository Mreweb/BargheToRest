<?php
class ModelProvince extends CI_Model{
    public function get_province_tariff_list($inputs){
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*'); 
        $this->db->from('province_electricity_tariff');
        $this->db->join('province' , 'province.ProvinceId = province_electricity_tariff.ProvinceId'); 
        if ($inputs['inputProvinceName'] != '') {
            $this->db->group_start();
            $this->db->like('province.ProvinceName', $inputs['inputProvinceName']);
            $this->db->group_end();
        }
        if ($inputs['inputProvinceId'] != '') {
            $this->db->group_start();
            $this->db->where('province.ProvinceId', $inputs['inputProvinceId']);
            $this->db->group_end();
        }
        
        $tempdb = clone $this->db; /* For Count Of Rows */
        $this->db->limit($end, $start);  
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;


    }
    public function get_province_tariff_list_by_province_id($id){ 
        $this->db->select('*'); 
        $this->db->from('province_electricity_tariff');
        $this->db->join('province' , 'province.ProvinceId = province_electricity_tariff.ProvinceId');  
        $this->db->where('province.ProvinceId', $id); 
        return $this->db->get()->result_array();  
    }
    public function do_add_province_tariff($inputs){
        $this->db->select('*'); 
        $this->db->from('province_electricity_tariff'); 
        $this->db->where('ProvinceId', $inputs['inputProvinceId']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'ProvinceId' => $inputs['inputProvinceId'],
            'LowPowerFromHour' => $inputs['inputLowPowerFromHour'], 
            'LowPowerToHour' => $inputs['inputLowPowerToHour'], 
            'MiddlePowerFromHour' => $inputs['inputMiddlePowerFromHour'], 
            'MiddlePowerToHour' => $inputs['inputMiddlePowerToHour'], 
            'PeakPowerFromHour' => $inputs['inputPeakPowerFromHour'], 
            'PeakPowerToHour' => $inputs['inputPeakPowerToHour'],   
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $inserId = $this->db->insert('province_electricity_tariff', $userArray);
        if ($inserId > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_edit_province_tariff($inputs){ 
        $userArray = array( 
            'LowPowerFromHour' => $inputs['inputLowPowerFromHour'], 
            'LowPowerToHour' => $inputs['inputLowPowerToHour'], 
            'MiddlePowerFromHour' => $inputs['inputMiddlePowerFromHour'], 
            'MiddlePowerToHour' => $inputs['inputMiddlePowerToHour'], 
            'PeakPowerFromHour' => $inputs['inputPeakPowerFromHour'], 
            'PeakPowerToHour' => $inputs['inputPeakPowerToHour'],   
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        ); 
        $this->db->where('ProvinceTariffId', $inputs['inputProvinceTariffId']);
        $this->db->update('province_electricity_tariff', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_delete_province_tariff($inputs){ 
        $this->db->delete('province_electricity_tariff', array(
         'ProvinceTariffId'=> $inputs['inputProvinceTariffId']
        ));
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    } 

    public function get_electricity_price(){
        $this->db->select('*'); 
        $this->db->from('electricity_price'); 
        $this->db->order_by('RowId DESC')->limit(1); 
        return $this->db->get()->result_array();  
    }
    public function do_add_electricity_price($inputs){
        $userArray = array(
            'HighPrice' => $inputs['inputHighPrice'],
            'LowPrice' => $inputs['inputLowPrice'],  
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $inserId = $this->db->insert('electricity_price', $userArray);
        if ($inserId > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }

    public function get_electricity_green_price(){
        $this->db->select('*'); 
        $this->db->from('electricity_green_price'); 
        $this->db->order_by('RowId DESC'); 
        return $this->db->get()->result_array();  
    }
    
    public function do_update_electricity_green_price ($inputs){
        $userArray = array( 
            'GreenHighPrice' => $inputs['inputGreenHighPrice'],  
            'GreenLowPrice' => $inputs['inputGreenLowPrice'],  
            'GreenInventory' => $inputs['inputGreenInventory'],  
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $inserId = $this->db->where('Month', $inputs['inputMonth']);
        $inserId = $this->db->update('electricity_green_price', $userArray);
        if ($inserId > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }


    
    
    
}
?>