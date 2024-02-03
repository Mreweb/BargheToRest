<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['base_url'] = 'http://localhost:8080/BargheToApi';
$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'persian';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['allow_get_array'] = TRUE;
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y/m/d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = '';
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'bartgheto_session';
$config['sess_samesite'] = 'Lax';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = TRUE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;
$config['cookie_samesite'] 	= 'Lax';
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_bargheto';
$config['csrf_cookie_name'] = 'csrf_bargheto';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';   
$config['HS256KEY'] = '5HFQjMFJe9bn0u6lZzAo_IY1GOSk1Q5b18fFtitXNfc';
$config['defaultPageSize'] = 10;
$config['TerminalId'] = '7133463';
$config['TerminaUserName'] = '7133463';
$config['TerminalPassword'] = '74889427'; 
$config['SMSAPI'] = '644751304D5155772B626847312B637A4862343438472B766C6762456841316C7A7A656F6B7757432B61633D';
$config['DBMessages'] = array(
    'SuccessAction' => array(
        'code' => 'SERVICE.SUCCESS',
        'message' => "عملیات با موفقیت انجام شد",
        'success' => true
    ),
    'ErrorAction' => array(
        'code' => 'SERVICE.ERROR',
        'message' => "عملیات با خطا مواجه شد",
        'success' => false
    ),
    'RequiredFields' => array(
        'code' => 'SERVICE.REQUIREDFIELD',
        'message' => 'تمامی مقادیر الزامی را وارد کنید',
        'success' => false
    ),
    'DuplicateInfo' => array(
        'code' => 'SERVICE.DUPLICATE',
        'message' => 'اطلاعات قبلا در سامانه ثبت شده است',
        'success' => false
    ),
    'NOTFOUND' => array(
        'code' => 'SERVICE.NotFound',
        'message' => 'موردی یافت نشد',
        'success' => false
    ),
    'MethodNotAllowed' => array(
        'code' => 'SERVICE.NOTALLOWED',
        'message' => 'متد فراخوانی معتبر نیست',
        'success' => false
    ),
    'AccessAction' => array(
        'code' => 'SERVICE.NOACCESS',
        'message' => 'دسترسی به این منبع محدود شده است',
        'success' => false
    )
);
$config['ENUM'] = [
    'PersonType'=> [
        'NORMAL' => 'عادی',
        'ORGANIZATION' => 'سازمانی'
    ],
    'OrderStatus'=> [
        'Pend' => 'در انتظار پرداخت',
        'Failed' => 'پرداخت ناموفق',
        'Done' => 'پرداخت موفق',
        'Reject' => 'برگشت واحد مالی',
        'Assigned' => 'تخصیص داده شده',
    ],
    'LegalType'=> [
        'Real' => 'حقیقی',
        'Legal' => 'حقوقی'
    ],
    'WeekDays'=> [
        '1' => 'شنبه',
        '2' => 'یکشنبه',
        '3' => 'دوشنبه',
        '4' => 'سه شنبه',
        '5' => 'چهارشنبه',
        '6' => 'پنجشنبه',
        '7' => 'جمعه'
    ],
];
