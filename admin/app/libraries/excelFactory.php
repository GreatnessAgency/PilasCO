<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
/*  
 * Clase para la exportación de resultados a excel  
 * @version 0.1 Primera version  
 */ 
require_once APPPATH ."third_party/PHPExcel/Classes/PHPExcel/IOFactory.php";   
class ExcelFactory extends PHPExcel_IOFactory {     
  public function __construct()
  {
    
  }
} 