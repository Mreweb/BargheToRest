<?php

class ModelAccount extends CI_Model{
    public function doLogin($inputs){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array(
            'Username ' => $inputs['inputPhone'],
            'Password' => md5($inputs['inputPassword'])
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $personInfo = $query->result_array()[0];
            $this->db->select('*');
            $this->db->from('person_roles');
            $this->db->where(array('PersonId' => $personInfo['PersonId']));
            $rolesQuery = $this->db->get();

            if($rolesQuery->num_rows() > 0){
                $roles = $rolesQuery->result_array();
                $this->session->set_userdata('AdminLoginInfo' , $personInfo);
                $this->session->set_userdata('LoginRoles' , $roles);
                $this->session->set_userdata('LoginPermissions' , getAdminPermissions($personInfo['PersonId']));
                $this->session->set_userdata('AdminIsLogged' , TRUE);

                foreach ($this->session->userdata('LoginRoles') as $role) {
                    if($role['Role'] == 'Admin'){
                        $arr = array( 'type' => "green",  'url' => base_url('Panel/Home'),  'content' => "ورود موفق...لطفا صبر کنید",  'success' => true );
                        return $arr;
                    }
                }
                foreach ($this->session->userdata('LoginRoles') as $role) {
                    if($role['Role'] == 'Marketing'){
                        $arr = array( 'type' => "green",  'url' => base_url('Panel/Orders'),  'content' => "ورود موفق...لطفا صبر کنید",  'success' => true );
                        return $arr;
                    }
                }

                foreach ($this->session->userdata('LoginRoles') as $role) {
                    if($role['Role'] == 'Finance'){
                        $arr = array( 'type' => "green",  'url' => base_url('Panel/FinanceTax/index'),  'content' => "ورود موفق...لطفا صبر کنید",  'success' => true );
                        return $arr;
                    }
                }
                foreach ($this->session->userdata('LoginRoles') as $role) {
                    if($role['Role'] == 'ServiceMan' || $role['Role'] == 'ServiceManBoss'){
                        $arr = array( 'type' => "green",  'url' => base_url('Panel/ServiceManHome'),  'content' => "ورود موفق...لطفا صبر کنید",  'success' => true );
                        return $arr;
                    }
                }
                foreach ($this->session->userdata('LoginRoles') as $role) {
                    if($role['Role'] == 'Tester'){
                        $arr = array( 'type' => "green",  'url' => base_url('Panel/TesterHome'),  'content' => "ورود موفق...لطفا صبر کنید",  'success' => true );
                        return $arr;
                    }
                }
                foreach ($this->session->userdata('LoginRoles') as $role) {
                    if($role['Role'] == 'Support'){
                        $arr = array( 'type' => "green",  'url' => base_url('Panel/MyTicket'),  'content' => "ورود موفق...لطفا صبر کنید",  'success' => true );
                        return $arr;
                    }
                }
                foreach ($this->session->userdata('LoginRoles') as $role) {
                    if($role['Role'] == 'ORG'){
                        $arr = array( 'type' => "green",  'url' => base_url('Organization/Home'),  'content' => "ورود موفق...لطفا صبر کنید",  'success' => true );
                        return $arr;
                    }
                }
            }
            else{
                $arr = array(
                    'type' => "red",
                    'content' => "اطلاعات نامعتبر است",
                    'success' => false
                );
                return $arr;
            }
        }
        else{
            $arr = array(
                'type' => "red",
                'content' => "اطلاعات نامعتبر است",
                'success' => false
            );
            return $arr;
        }
    }
}
?>