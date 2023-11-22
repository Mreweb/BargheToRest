<?php
/**
 * Function to Detect Bad User Input To Prevent XSS Attacks
 * @params String $string
 * @return string
 * @author MohammadrezaEsmaeeli (info@mreweb.ir)
 * @license GPL
 * */
function makeSafeInput($string)
{
    $string = str_ireplace("<?", "", $string);
    $string = str_ireplace("?>", "", $string);
    $string = str_ireplace("<?php", "", $string);
    $string = str_ireplace("?>", "", $string);
    $string = str_ireplace("<body", "", $string);
    $string = str_ireplace("<embed", "", $string);
    $string = str_ireplace("<frame", "", $string);
    $string = str_ireplace("<script", "", $string);
    $string = str_ireplace("<frameset", "", $string);
    $string = str_ireplace("<html", "", $string);
    $string = str_ireplace("<iframe", "", $string);
    $string = str_ireplace("<img", "", $string);
    $string = str_ireplace("<style", "", $string);
    $string = str_ireplace("<layer", "", $string);
    $string = str_ireplace("<link", "", $string);
    $string = str_ireplace("<ilayer", "", $string);
    $string = str_ireplace("<meta", "", $string);
    $string = str_ireplace("<object", "", $string);
    $string = str_ireplace("<", "", $string);
    $string = str_ireplace(">", "", $string);
    $string = str_ireplace("javascript", "", $string);
    $string = str_ireplace("java&#010", "", $string);
    $string = str_ireplace("java&#X0A", "", $string);
    $string = str_ireplace("u003e", "", $string);
    $string = str_ireplace("alert ", "", $string);
    $string = str_ireplace("drop ", "", $string);
    $string = str_ireplace("select ", "", $string);
    $string = str_ireplace("update ", "", $string);
    $string = str_ireplace("script ", "", $string);
    $string = str_ireplace("1=1", "", $string);
    $string = str_ireplace("delete ", "", $string);
    return $string;
}

function custom_filter_input($inputs, $strip_tag = true, $remove_invisible = true, $custom_security = true )
{
    if ($strip_tag) {
        if(!is_array($inputs)){
            $inputs = array_map(function ($v) { return strip_tags($v); }, $inputs);
        }
    }
    if ($remove_invisible) {
        if(!is_array($inputs)){
            $inputs = array_map(function ($v) { return remove_invisible_characters($v); }, $inputs);
        }
    }
    if ($custom_security) {
        if(!is_array($inputs)){
            $inputs = array_map('makeSafeInput', $inputs);
        }
    }
    return $inputs;
}


?>