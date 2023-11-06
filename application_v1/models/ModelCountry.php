<?php
class ModelCountry extends CI_Model
{
    public function get_country_list()
    {
        $this->db->select('*');
        $this->db->from('country');
        $this->db->order_by('FaName', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        $arr = array();
        return $arr;
    }
    public function get_province_list($id)
    {
        $this->db->select('*');
        $this->db->from('province');
        if ($id != null) {
            $this->db->where(array('ProvinceId' => $id));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        $arr = array();
        return $arr;
    }
    public function get_city_list($id)
    {
        $this->db->select('*');
        $this->db->from('city');
        if ($id != null) {
            $this->db->where(array('CityId' => $id));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        $arr = array();
        return $arr;
    }
    public function get_city_by_province_id($Id)
    {
        $this->db->select('*');
        $this->db->from('city');
        $this->db->where(array('CityProvinceId' => $Id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        $arr = array();
        return $arr;
    }

}
?>