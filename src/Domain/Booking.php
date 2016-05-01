<?php
	namespace LMQP\Domain;
	
	class Booking
	{
		use Secure;

		private $firstname;
		private $lastname;
		private $email;
		private $phone;
		private $address;
		private $activity;
		private $agreement;

		public static $required=array('firstname' 	=> true,
										'lastname' 	=> true,
										'email' 	=> true,
										'phone' 	=> true,
										'address' 	=> true,
										'activity'	=> true,
										'agreement'	=> true
									);

		public static $translation=array('firstname'	=> 'Prénom', 
										'lastname'		=> 'Nom', 
										'email' 		=> 'Email',
										'phone' 		=> 'Téléphone', 
										'address' 		=> 'Adresse',
										'activity'		=> 'Activité',
										'agreement'		=> 'Accord'
									);
		
		public static $validationBooking = 
			  array('firstname'	=> 'Le prénom doit se composer uniquement de lettres, tirets, espaces.', 
					'lastname'	=> 'Le nom doit se composer uniquement de lettres, tirets, espaces.', 
					'email' 	=> 'L\' adresse e-mail doit être de la forme : aa@bb.cc où aa, bb, cc doivent commencer par une lettre et peuvent être constitués de lettres, chiffres, tirets et points. ',
					'phone' 	=> 'Le numéro de téléphone ne peut être composé que de chiffres, tirets, points, espaces.', 
					'address' 	=> 'L\'adresse peut contenir toutes sortes de caractères.',
					'activity'	=> 'L\'activité doit se composer de lettres, virgules et espaces.',
					'agreement'	=> 'Vous devez accepter les conditions et vous engager pleinement.'
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
		
		public function getAddress()
		{
			return $this->address;
		}
		
		public function setAddress($address)
		{
			$this->address = $this->secureString($address);
		}
		
		public function getActivity()
		{
			return $this->activity;
		}
		
		public function setActivity($activity)
		{
			$this->activity = $this->secureString($activity);
		}
		
		public function getAgreement()
		{
			return $this->agreement;
		}
		
		public function setAgreement($agreement)
		{
			$agreement = $this->validateBoolean($agreement);
			$this->agreement = $agreement;
		}
		
		public function isComplete()
		{
			return	(!empty($this->firstname) &&
					!empty($this->lastname) &&
					!empty($this->email) &&
					!empty($this->phone) &&
					!empty($this->address) &&
					!empty($this->activity) &&
					!empty($this->agreement));
		}
	}
?>