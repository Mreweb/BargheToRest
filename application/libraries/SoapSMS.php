<?php
    class SoapSMS{
        public $value = NULL;
        public $method = NULL;
        public $url = NULL;
        public $type = '';
        function connect($url,$method,$value,$type=''){
            $this->value = $value;
            $this->method = $method;
            $this->url = $url;
            $this->type = $type;
            ini_set("soap.wsdl_cache_enabled", "0");
            $client = new SoapClient($this->url , ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);
            $result = $client->__SoapCall($this->method, array($this->value));
            if($this->type == 'object')
                return get_object_vars($result);
            $merge = $this->method.'Result';
            if($result->$merge->string != '')
                return $result->$merge->string;
            else
                return $result->$merge;
        }
    }
?>