<?php
class ModelBill extends CI_Model
{

    /* For Single User */
    public function get_user_bill_list($inputs)
    {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        $this->db->where('person_bill.SoftDelete', 0);
        if ($inputs['inputBillTitle'] != '') {
            $this->db->group_start();
            $this->db->like('BillTitle', $inputs['inputBillTitle']);
            $this->db->group_end();
        }
        if ($inputs['inputBillNumberId'] != '') {
            $this->db->group_start();
            $this->db->like('BillNumberId', $inputs['inputBillNumberId']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonLastName'] != '') {
            $this->db->group_start();
            $this->db->like('PersonLastName', $inputs['inputPersonLastName']);
            $this->db->or_like('PersonFirstName', $inputs['inputPersonLastName']);
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
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $this->db->order_by('person_bill.CreateDateTime', 'DESC');
        $this->db->group_by('person_bill.BillGUID');
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;


    }
    public function get_user_all_bill_list($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->order_by('person_bill.CreateDateTime', 'DESC');
        $this->db->group_by('person_bill.BillGUID');
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        return $result;


    }

    public function do_add_bill($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'BillGUID' => $this->uuid->v4(),
            'BillTitle' => $inputs['inputBillTitle'],
            'BillNumberID' => $inputs['inputBillNumberId'],
            'BillPersonId' => $inputs['inputPersonId'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $this->db->insert('person_bill', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_bill($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $this->db->where('BillGUID !=', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'BillTitle' => $inputs['inputBillTitle'],
            'BillNumberID' => $inputs['inputBillNumberId'],
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->update('person_bill', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_delete_bill($inputs)
    {
        $userArray = array(
            'SoftDelete' => 1,
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->update('person_bill', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_add_legal_info($inputs)
    {

        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'PersonId' => $inputs['inputPersonId'],
            'BillGUID' => $inputs['inputBillGUID'],
            'RealName' => $inputs['inputRealName'],
            'RealLastName' => $inputs['inputRealLastName'],
            'RealNationalCode' => $inputs['inputRealNationalCode'],
            'RealPhone' => $inputs['inputRealPhone'],
            'RealProvinceId' => $inputs['inputRealProvinceId'],
            'RealCityId' => $inputs['inputRealCityId'],
            'RealAddress' => $inputs['inputRealAddress'],
            'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
            'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
            'LegalCompanyId' => $inputs['inputLegalCompanyId'],
            'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
            'LegalPhone' => $inputs['inputLegalPhone'],
            'LegalProvinceId' => $inputs['inputLegalProvinceId'],
            'LegalCityId' => $inputs['inputLegalCityId'],
            'LegalAddress' => $inputs['inputLegalAddress'],
            'CreatePersonId' => $inputs['inputPersonId'],
            'CreateDateTime' => time()
        );
        
        $this->db->insert('person_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_legal_info($inputs)
    {

        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $userArray = array(
                'BillGUID' => $inputs['inputBillGUID'],
                'RealName' => $inputs['inputRealName'],
                'RealLastName' => $inputs['inputRealLastName'],
                'RealNationalCode' => $inputs['inputRealNationalCode'],
                'RealPhone' => $inputs['inputRealPhone'],
                'RealProvinceId' => $inputs['inputRealProvinceId'],
                'RealCityId' => $inputs['inputRealCityId'],
                'RealAddress' => $inputs['inputRealAddress'],
                'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
                'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
                'LegalCompanyId' => $inputs['inputLegalCompanyId'],
                'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
                'LegalPhone' => $inputs['inputLegalPhone'],
                'LegalProvinceId' => $inputs['inputLegalProvinceId'],
                'LegalCityId' => $inputs['inputLegalCityId'],
                'LegalAddress' => $inputs['inputLegalAddress'],
                'CreatePersonId' => $inputs['inputPersonId'],
                'CreateDateTime' => time()
            );
            $this->db->where('PersonId', $inputs['inputPersonId']);
            $this->db->update('person_bill_legal_info', $userArray);
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('NOTFOUND', null);
        }

    }
    /* End For Single User */


    /* For Admin */
    public function get_bill_list($inputs)
    {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');

        if ($inputs['inputShowDeleted'] != '') {
            $this->db->where('person_bill.SoftDelete', $inputs['inputShowDeleted']);
        }
        if ($inputs['inputBillTitle'] != '') {
            $this->db->group_start();
            $this->db->like('BillTitle', $inputs['inputBillTitle']);
            $this->db->group_end();
        }
        if ($inputs['inputBillNumberId'] != '') {
            $this->db->group_start();
            $this->db->like('BillNumberId', $inputs['inputBillNumberId']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonLastName'] != '') {
            $this->db->group_start();
            $this->db->like('PersonLastName', $inputs['inputPersonLastName']);
            $this->db->or_like('PersonFirstName', $inputs['inputPersonLastName']);
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
        if ($inputs['inputPersonId'] != '') {
            $this->db->group_start();
            $this->db->where('BillPersonId', $inputs['inputPersonId']);
            $this->db->group_end();
        }
        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $this->db->order_by('person_bill.CreateDateTime', 'DESC');
        $this->db->group_by('person_bill.BillGUID');
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;


    }
    public function get_bill_by_guid($guid)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillGUID', $guid);
        return $this->db->get()->result_array();
    }
    public function do_add_bill_by_admin($inputs)
    {
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return get_req_message('NotFound', 'فردی با این مشخصات یافت نشد');
        }
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'BillGUID' => $this->uuid->v4(),
            'BillTitle' => $inputs['inputBillTitle'],
            'BillNumberID' => $inputs['inputBillNumberId'],
            'BillPersonId' => $inputs['inputPersonId'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->insert('person_bill', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_bill_by_admin($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $this->db->where('BillGUID !=', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'BillTitle' => $inputs['inputBillTitle'],
            'BillNumberID' => $inputs['inputBillNumberId'],
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->update('person_bill', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_delete_bill_by_admin($inputs)
    {
        $userArray = array(
            'SoftDelete' => 1,
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->update('person_bill', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_add_legal_info_by_admin($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'PersonId' => $inputs['inputPersonId'],
            'BillGUID' => $inputs['inputBillGUID'],
            'RealName' => $inputs['inputRealName'],
            'RealLastName' => $inputs['inputRealLastName'],
            'RealNationalCode' => $inputs['inputRealNationalCode'],
            'RealPhone' => $inputs['inputRealPhone'],
            'RealProvinceId' => $inputs['inputRealProvinceId'],
            'RealCityId' => $inputs['inputRealCityId'],
            'RealAddress' => $inputs['inputRealAddress'],
            'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
            'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
            'LegalCompanyId' => $inputs['inputLegalCompanyId'],
            'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
            'LegalPhone' => $inputs['inputLegalPhone'],
            'LegalProvinceId' => $inputs['inputLegalProvinceId'],
            'LegalCityId' => $inputs['inputLegalCityId'],
            'LegalAddress' => $inputs['inputLegalAddress'],
            'CreatePersonId' => $inputs['inputAdminPersonId'],
            'CreateDateTime' => time()
        );
        $this->db->insert('person_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_legal_info_by_admin($inputs){
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return get_req_message('NotFound', null);
        }
        $userArray = array(
            'PersonId' => $inputs['inputPersonId'],
            'BillGUID' => $inputs['inputBillGUID'],
            'RealName' => $inputs['inputRealName'],
            'RealLastName' => $inputs['inputRealLastName'],
            'RealNationalCode' => $inputs['inputRealNationalCode'],
            'RealPhone' => $inputs['inputRealPhone'],
            'RealProvinceId' => $inputs['inputRealProvinceId'],
            'RealCityId' => $inputs['inputRealCityId'],
            'RealAddress' => $inputs['inputRealAddress'],
            'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
            'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
            'LegalCompanyId' => $inputs['inputLegalCompanyId'],
            'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
            'LegalPhone' => $inputs['inputLegalPhone'],
            'LegalProvinceId' => $inputs['inputLegalProvinceId'],
            'LegalCityId' => $inputs['inputLegalCityId'],
            'LegalAddress' => $inputs['inputLegalAddress'],
            'CreatePersonId' => $inputs['inputAdminPersonId'],
            'CreateDateTime' => time()
        );
        $this->db->insert('persnon_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    /* End For Admin */



    /* Public */
    public function get_bill_power_data($inputs)
    {
        $this->db->select('BillGUID , person_bill.BillNumberId , company_name , contract_demand , customer_name , customer_family , serial_number , payment_dead_line');
        $this->db->from('person_bill');
        $this->db->join('bill_power_data_detail', 'bill_power_data_detail.bill_identifier = person_bill.BillNumberId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('person_bill.BillGUID', $inputs['guid']);
        $this->db->where('person_bill.BillPersonId', $inputs['inputPersonId']);
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        return $result;
    }
    public function get_bill_sale_data($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('bill_sale_data_detail', 'bill_sale_data_detail.BillNumberId = person_bill.BillNumberId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('person_bill.BillGUID', $inputs['guid']);
        $this->db->where('person_bill.BillPersonId', $inputs['inputPersonId']);
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        return $result;
    }
    public function get_bill_plans($inputs){
        $bill = $this->get_bill_by_guid($inputs['guid']);
        $avgKWS = $this->db->query("SELECT ((SUM(low_cons)+SUM(normal_cons)+SUM(peak_cons))/SUM(total_days)/24) AS TotalCons FROM (SELECT * FROM bill_sale_data_detail WHERE BillNumberId = '" . $bill[0]['BillNumberId'] . "'   order by sale_year DESC , sale_prd DESC LIMIT 12) AS T")->result_array()[0]['TotalCons'];
        $avgKWS = round($avgKWS , 2);


        $LowPrice = $inputs['electricity_price']['LowPrice'];
        $HighPrice = $inputs['electricity_price']['HighPrice'];
        $priceGap = $HighPrice - $LowPrice;

        $todayDate = $inputs['todayDate'];
        $todayDay = explode("/",$inputs['todayDate'])[2]; 
        
        $currentMonth = intval($inputs['currentMonth']);

        $prevMonth = $currentMonth-1;
        if($prevMonth < 1){
            $prevMonth = 12;
        }

        $nextOneMonth = $currentMonth+1;
        $nextTwoMonth = $currentMonth+2;
        if($nextOneMonth > 12){
            $nextOneMonth = 1;
        } 
        if($nextTwoMonth > 12){
            $nextTwoMonth = 1;
        }

        echo "BillNumberId ".($bill[0]['BillNumberId']).PHP_EOL; 
        echo "current month ".($currentMonth).PHP_EOL; 
        echo "current day ".($todayDay).PHP_EOL; 

         
        $currentMonthTotalDays = 0;
        if($currentMonth <= 6){
            $currentMonthTotalDays = 31;
        } else if($currentMonth > 6 && $currentMonth < 12){
            $currentMonthTotalDays = 30;
        } else{
            $currentMonthTotalDays = 29;
        }
 

        $nextOneMonthDays = 0;

        if($nextOneMonth <= 6){
            $nextOneMonthDays = 31;
        } else if($nextOneMonth > 6 && $nextOneMonth < 12){
            $nextOneMonthDays = 30;
        } else{
            $nextOneMonthDays = 29;
        }

        $nextTwoMonthDays = 0;
        if($nextTwoMonth <= 6){
            $nextTwoMonthDays = 31;
        } else if($nextTwoMonth > 6 && $nextTwoMonth < 12){
            $nextTwoMonthDays = 30;
        } else{
            $nextTwoMonthDays = 29;
        }
        $nextTwoMonthDays = $nextTwoMonthDays+$nextOneMonthDays;
 

        echo "Next One Month ".$nextOneMonth.PHP_EOL;
        echo "Next One Month Days ".$nextOneMonthDays.PHP_EOL;

        echo "Next two Month ".$nextTwoMonth.PHP_EOL;
        echo "Next two Month Days ".$nextTwoMonthDays.PHP_EOL;


 
        $remainsDayToEndOfMonth = $currentMonthTotalDays - $todayDay;
        echo "remains day to end of month day ".$remainsDayToEndOfMonth.PHP_EOL;
        
        echo "avgKWS ".($avgKWS).PHP_EOL; 

        echo "priceGap ".$priceGap.PHP_EOL;

        $requestedKw = 2000; 

        echo "========================================".PHP_EOL;
        $thisMonthDiscount = round($priceGap/$remainsDayToEndOfMonth , 2);
        echo "Discount Per KW Per Day For Current Month ".$thisMonthDiscount.PHP_EOL;

        $thisMonthCalculatedPrice = $HighPrice - ($remainsDayToEndOfMonth*$thisMonthDiscount);
        echo "CalCulatedPrice ".$thisMonthCalculatedPrice.PHP_EOL;

        $thisMonthPowerCost =  $requestedKw * $remainsDayToEndOfMonth * 24  * $thisMonthCalculatedPrice;
        echo "thisMonthPowerCost ".number_format($thisMonthPowerCost).PHP_EOL;

        echo "========================================".PHP_EOL;


        $nextOneMonthDiscount = round($priceGap/($remainsDayToEndOfMonth+$nextOneMonthDays), 2); 
        echo "Discount Per KW For Next One Month ".$nextOneMonthDiscount.PHP_EOL;

        $nextMonthCalculatedPrice = $HighPrice-$nextOneMonthDiscount;
        echo "CalCulatedPrice ".$nextMonthCalculatedPrice.PHP_EOL; 
 
        $nextMonthPowerCost =  $requestedKw * ($remainsDayToEndOfMonth+$nextOneMonthDays) * 24 * $avgKWS * $nextMonthCalculatedPrice;

        echo "next One MonthPowerCost ".number_format($nextMonthPowerCost).PHP_EOL;

        echo "========================================".PHP_EOL;


        $nextTwoMonthDiscount = round($priceGap/($remainsDayToEndOfMonth+$nextOneMonthDays+$nextTwoMonthDays), 2);  
        echo "Discount Per KW For Next Two Month ".$nextTwoMonthDiscount.PHP_EOL;

        $nextTwoMonthCalculatedPrice = $HighPrice-$nextTwoMonthDiscount;
        echo "CalCulatedPrice ".$nextTwoMonthCalculatedPrice.PHP_EOL; 
 
        $nextTwoMonthPowerCost =  $requestedKw * ($remainsDayToEndOfMonth+$nextOneMonthDays+$nextTwoMonthDays) * 24 * $avgKWS * $nextTwoMonthCalculatedPrice;

        echo "next One MonthPowerCost ".number_format($nextTwoMonthPowerCost).PHP_EOL;

        echo "========================================".PHP_EOL;

        /*echo ($avgKWS);
        echo "<br>";
        echo($HighPrice);
        echo "<br>";
        echo($LowPrice); */

        die();





    }
    /* End Public */


}
?>