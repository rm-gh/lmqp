<?php
	namespace LMQP\Domain;
	
	class Message
	{
		use Secure;

		private $firstname;
		private $lastname;
		private $email;
		private $phone;
		private $message;

		public static $required=array('firstname' 	=> true,
										'lastname' 	=> true,
										'email' 	=> true,
										'phone' 	=> false,
										'message' 	=> true
									);

		public static $translation=array('firstname'	=> 'Prénom', 
										'lastname'		=> 'Nom', 
										'email' 		=> 'Email',
										'phone' 		=> 'Téléphone', 
										'message' 		=> 'Message'
									);
		
		public static $validationMessage = 
			  array('firstname'	=> 'Le prénom doit se composer uniquement de lettres, tirets, espaces.', 
					'lastname'	=> 'Le nom doit se composer uniquement de lettres, tirets, espaces.', 
					'email' 	=> 'L\' adresse e-mail doit être de la forme : aa@bb.cc où aa, bb, cc doivent commencer par une lettre et peuvent être constitués de lettres, chiffres, tirets et points. ',
					'phone' 	=> 'Le numéro de téléphone ne peut être composé que de chiffres, tirets, points, espaces.', 
					'message' 	=> 'Le message peut contenir toutes sortes de caractères.'
					);
		
		public function getFirstname()
		{
			return $this->firstname;
		}
		
		public function setFirstname($firstname)
		{
			$firstname = $this->validateName($firstname);
			$firstname = $this->secureString($firstname);
			$this->firstname = ucfirst($firstname);
		}
		
		public function getLastname()
		{
			return $this->lastname;
		}
		
		public function setLastname($lastname)
		{
			$lastname = $this->secureString($lastname);
			$lastname = $this->validateName($lastname);
			$this->lastname = ucfirst($lastname);
		}
		
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
		
		public function getPhone()
		{
			return $this->phone;
		}
		
		public function setPhone($phone)
		{
			$phone = $this->secureString($phone);
			$phone = $this->validatePhone($phone);
			$this->phone = $phone;
		}
		
		public function getMessage()
		{
			return $this->message;
		}
		
		public function setMessage($message)
		{
			$this->message = $this->secureString($message);
		}
	}
?>