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
        $this->db->select('*');
        $this->db->from('person');
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

 


}

?>