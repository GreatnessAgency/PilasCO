<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Originaly CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
//modification by Yeb Reitsma

/* 
in case you use it with the HMVC modular extention
uncomment this and remove the other lines
load the MX_Loader class */
//require APPPATH."third_party/MX/Config.php";

//class MY_Config extends MX_Config {
 
class Ext_Config extends CI_Config {

    function site_url($uri = '')
    {    
        if (is_array($uri))
        {
            $uri = implode('/', $uri);
        }
        
        if (function_exists('get_instance'))        
        {
            $CI =& get_instance();
            $uri = $CI->lang->localized($uri);            
        }

        return parent::site_url($uri);
    }
        
}

// END MY_Config Class

/* End of file MY_Config.php */
/* Location: ./application/core/MY_Config.php */  