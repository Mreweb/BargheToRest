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
    public function doEditByColumn($inputs)
    {
        $userArray = array(
            $inputs['inputColumn'] => $inputs['inputValue']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);

    }
    public function getPersonById($personId)
    {
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }
    public function getPersonByOrderId($orderId)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->join('person' , 'person.PersonId = orders.OrderPersonId');
        $this->db->where(array('orderId' => $orderId));
        return $this->db->get()->result_array();
    }
    public function getPersonByNationalCode($NationalCode)
    {
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonNationalCode' => $NationalCode));
        return $this->db->get()->result_array();
    }
    public function getPersonRolesById($personId)
    {
        $this->db->select('Role');
        $this->db->from('person_roles');
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }
    public function getAddressByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('person_address');
        $this->db->join('state' , 'state.StateId = person_address.StateId');
        $this->db->join('city' , 'city.CityId  = person_address.CityId ');
        $this->db->where(array('PersonId' => $personId));
        $this->db->order_by('AddressId', 'DESC');
        return $this->db->get()->result_array();
    }
    public function getAddressByAddressPersonId($addressId, $personId)
    {
        $this->db->select('*');
        $this->db->from('person_address');
        $this->db->where(array('AddressId' => $addressId));
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }
    public function getAddressByAddressId($addressId)
    {
        $this->db->select('*');
        $this->db->from('person_address');
        $this->db->join('state' , 'state.StateId = person_address.StateId');
        $this->db->join('city' , 'city.CityId  = person_address.CityId ');
        $this->db->where(array('AddressId' => $addressId));
        $this->db->order_by('AddressId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_person_all_info_by_person_id($personId){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonId' => $personId));
        $data['info'] = $this->db->get()->result_array()[0];
        $this->db->reset_query();

        $this->db->select('*');
        $this->db->from('person_account_balance');
        $this->db->where(array('PersonId' => $personId));
        $data['account_balance'] = $this->db->get()->result_array()[0];
        $this->db->reset_query();

        $this->db->select('*');
        $this->db->from('person_legal_info');
        $this->db->join('province' , 'province.ProvinceId = person_legal_info.LegalProvinceId');
        $this->db->join('city' , 'city.CityId = person_legal_info.LegalCityId');
        $this->db->where(array('PersonId' => $personId));
        $data['legal_info'] = $this->db->get()->result_array()[0];
        return $data;

    }


}

?>