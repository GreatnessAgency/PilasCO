<?php
class Minifyhtml {
	function output(){
		$CI =& get_instance();
		$buffer = $CI->output->get_output();
		$search = array( '/\t+/', '/(?<![\:\"\'])\/\/(.*)\\n/','/>[\s]+</', '/[\r\n]+/', '/ {2,}/' );
		$replace = array( "", "",'><', "", " ");
		$buffer = preg_replace($search, $replace, $buffer);
		$CI->output->set_output($buffer);
		$CI->output->_display();
	}
}