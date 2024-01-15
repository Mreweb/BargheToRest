<?php


class ModelPerson extends CI_Model{

    public function doAdd($inputs){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonNationalCode' => $inputs['inputPersonNationalCode']));
        $data = $this->db->get()->result_array();
        if (!empty($data)) {
            return $data[0]['PersonId'];
        } else {
            $userArray = array(
                'PersonFirstName' => $inputs['inputPersonFirstName'],
                'PersonLastName' => $inputs['inputPersonLastName'],
                'PersonNationalCode' => $inputs['inputPersonNationalCode'],
                'PersonPhone' => $inputs['inputPersonPhone'],
                'UserEmail' => $inputs['inputUserEmail'],
                'PersonCode' => $inputs['inputPersonCode'],
                'Username' => $inputs['inputUsername'],
                'Password' => md5($inputs['inputPassword'])
            );
            $this->db->insert('person', $userArray);
            return $this->db->insert_id();
        }
    }
    public function get_person_by_id($personId){
        $this->db->select('PersonId, PersonFirstName,PersonLastName,PersonNationalCode,PersonPhone');
        $this->db->select('PersonProvinceId,PersonCityId,PersonAddress,IsActive');
        $this->db->select('PersonType,ProvinceName,CityName');
        $this->db->from('person');
        $this->db->join('province' , 'province.ProvinceId = person.PersonProvinceId' , 'left');
        $this->db->join('city' , 'city.CityId = person.PersonCityId' , 'left');
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }
    public function get_person_legal_info_by_id($personId){
        $this->db->select('PersonId,LegalOrganizationName,LegalFinanceCode,LegalCompanyId,LegalRegisterNumber,LegalPhone');
        $this->db->select('LegalProvinceId,LegalCityId,LegalAddress');
        $this->db->from('person_legal_info'); 
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }
    public function get_person_by_national_code($NationalCode){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonNationalCode' => $NationalCode));
        return $this->db->get()->result_array();
    }
    public function get_person_roles($personId){
        $this->db->select('Role');
        $this->db->from('person_roles');
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }
    public function get_person_legal_info($personId){
        $this->db->select('*');
        $this->db->from('person_legal_info');
        $this->db->join('province' , 'province.ProvinceId = person_legal_info.LegalProvinceId');
        $this->db->join('city' , 'city.CityId  = person_legal_info.LegalCityId');
        $this->db->where(array('PersonId' => $personId)); 
        return $this->db->get()->result_array();
    }
    public function getAddressByAddressPersonId($addressId, $personId){
        $this->db->select('*');
        $this->db->from('person_address');
        $this->db->where(array('AddressId' => $addressId));
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }

    public function get_person_all_info_by_person_id($addressId, $personId){
        $this->db->select('*');
        $this->db->from('person_address');
        $this->db->where(array('AddressId' => $addressId));
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }
    
    public function get_persons_list($inputs){
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize'); 
        $this->db->select('PersonFirstName , PersonLastName , PersonNationalCode , PersonPhone');
        $this->db->from('person');
        $this->db->join('province', 'province.ProvinceId = person.PersonProvinceId');
        $this->db->join('city', 'city.CityId = person.PersonCityId');
        if ($inputs['inputPersonFirstName'] != '') {
            $this->db->group_start();
            $this->db->like('PersonFirstName', $inputs['inputPersonFirstName']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonLastName'] != '') {
            $this->db->group_start();
            $this->db->like('PersonLastName', $inputs['inputPersonLastName']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonNationalCode'] != '') {
            $this->db->group_start();
            $this->db->like('PersonNationalCode', $inputs['inputPersonNationalCode']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonPhone'] != '') {
            $this->db->group_start();
            $this->db->like('PersonPhone', $inputs['inputPersonPhone']); 
            $this->db->group_end();
        } 
        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $this->db->order_by('person.CreateDateTime', 'DESC');
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;


    }
    
    public function get_person_detail($personId){

        $data['personInfo'] = $this->get_person_by_id($personId)[0];
        $data['personLegalInfo'] = $this->get_person_legal_info_by_id($personId)[0];

        print_r($data);
    }
    
 


}

?>