<?php

class ModelProfile extends CI_Model{

    /* Setting */

    public function do_change_info($inputs){
        if ($inputs['inputNationalCode'] != '' && $inputs['inputNationalCode'] != null) {
            $this->db->select('*');
            $this->db->from('person');
            $this->db->where(
                array(
                    'PersonId !=' => $inputs['inputPersonId'],
                    'PersonNationalCode' => $inputs['inputNationalCode'],
                )
            );
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return get_req_message('DuplicateInfo', null);
            }
        }
        $userArray = array(
            'PersonFirstName' => $inputs['inputFirstName'],
            'PersonLastName' => $inputs['inputLastName'], 
            'PersonNationalCode' => $inputs['inputNationalCode'],
            'PersonAddress' => $inputs['inputAddress'],
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);
        return get_req_message('SuccessAction');

    }

    public function doChangeCompanyInfo($inputs)
    {
        $userArray = array(
            'LegalInvoiceCompanyName' => $inputs['inputLegalInvoiceCompanyName'],
            'LegalInvoiceCompanyId' => $inputs['inputLegalInvoiceCompanyId'],
            'LegalInvoiceCompanyFinanceCode' => $inputs['inputLegalInvoiceCompanyFinanceCode'],
            'LegalInvoiceCompanyPostalCode' => $inputs['inputLegalInvoiceCompanyPostalCode'],
            'LegalInvoiceCompanyAddress' => $inputs['inputLegalInvoiceCompanyAddress'],
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputModifyPersonId']
        );
        $this->db->where('PersonId', $inputs['inputModifyPersonId']);
        $this->db->update('person_invoice_info', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];
    }

    /* End Setting */
}

?>