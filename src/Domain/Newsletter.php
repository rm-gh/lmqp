<?php
	namespace LMQP\Domain;
	
	class Newsletter
	{
		use Secure;
		
		private $email;
		private $active;

		public static $required=array('email' => true, 'active' => true);
		public static $translation=array('email' => 'Email', 'active' => 'Actif');
		public static $validationNewsletter = array(
			'email' 	=> 'L\' adresse e-mail doit être de la forme : aa@bb.cc où aa, bb, cc doivent commencer par une lettre et peuvent être constitués de lettres, chiffres, tirets et points. ',
			'active'	=> 'Cocher pour recevoir la newsletter. Décocher sinon.'
		);
		
		public function getEmail()
		{
			return $this->email;
		}
		
		public function setEmail($email)
		{
			$email = $this->secureString($email);
			$email = $this->validateEmail($email);
			$this->email = $email;
		}

		public function getActive()
		{
			return $this->active;
		}
		
		public function setActive($active)
		{
			$active = $this->validateBoolean($active);
			$this->active = $active;
		}
	}
?>