<?php
function loginRecord($UserArray){
    $ci =& get_instance();
    $ci->db->insert('login_records', $UserArray);
}

/*function getTaxCategories(){
    $ci =& get_instance();
    $ci->db->select('*');
    $ci->db->from('tax_category');
    $ci->db->where('IsActive', 1);
    $ci->db->order_by('TaxCategoryId', 'DESC');
    return $ci->db->get()->result_array();
}*/
?>