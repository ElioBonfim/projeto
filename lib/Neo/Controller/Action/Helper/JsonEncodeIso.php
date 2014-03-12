<?php
class Zend_Controller_Action_Helper_JsonEncodeIso extends Zend_Controller_Action_Helper_Abstract {


	public function jsonEncodeIso($array)
	{
		$new_arr  = array();
		foreach ($array as $arr):
		
				foreach($arr as $key => $value):
					$arr[$key] = utf8_encode($value);
   				endforeach;
				
		array_push($new_arr, $arr);
		endforeach;	
		return $new_arr;
	}



}