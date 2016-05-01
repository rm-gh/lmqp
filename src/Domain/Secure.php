<?php
	namespace LMQP\Domain;
	
	trait Secure
	{
		public function secureString($str)
		{
			return htmlspecialchars(stripslashes(trim($str)));
		}
		
		public function validateName($str)
		{
			if (preg_match("/^[a-zA-Z]*$/", $str))
				return $str;
			return null;
		}
		
		public function validateEmail($str)
		{
			if (filter_var($str, FILTER_VALIDATE_EMAIL))
				return $str;
			return null;
		}
		
		public function validatePhone($str)
		{
			if (preg_match("/^[\d\-\.\s]*$/", $str))
				return $str;
			return null;
		}
		
		public function validateBoolean($var)
		{
			return filter_var($var, FILTER_VALIDATE_BOOLEAN, array('flag' => FILTER_NULL_ON_FAILURE));
		}
	}
?>