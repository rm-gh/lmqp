<?php
	namespace LMQP\DAO;
	
	use LMQP\Domain\Newsletter;
	
	class NewsletterDAO extends DAO
	{
		public function find($email, $test=false)
		{
			$sql = "select * from t_newsletter where email = ?";
			$row = $this->getDb()->fetchAssoc($sql, array($email));
			
			if ($test)
			{
				if ($row)
					return true;
				else
					return false;
			}
			else
			{
				if ($row)
					return $this->buildDomainObject($row);
				else
					return null;
			}
		}
		
		public function findAll()
		{
			$sql = "select * from t_newsletter order by email";
			$result = $this->getDb()->fetchAll($sql);
			
			$entities = array();
			foreach($result as $row)
				$entities[] = $this->buildDomainObject($row);
			
			return $entities;
		}
		
		public function findActive()
		{
			$sql = "select * from t_newsletter where active = true order by email";
			$result = $this->getDb()->fetchAll($sql);
			
			$entities = array();
			foreach($result as $row)
				$entities[] = $this->buildDomainObject($row);
			
			return $entities;
		}
		
		protected function buildDomainObject($row)
		{
			$newsletter = new Newsletter();
			$newsletter->setEmail($row['email']);
			$newsletter->setActive($row['active']);
			
			return $newsletter;
		}
		
		public function save(Newsletter $newsletter)
		{
			$data = array(
				'email' => $newsletter->getEmail(),
				'active' => $newsletter->getActive());
				
			if ($this->find($newsletter->getEmail(), true))
				$this->getDb()->update('t_newsletter', $data, array('email' => $newsletter->getEmail()));
			else
				$this->getDb()->insert('t_newsletter', $data);
		}
		
		public function delete($email)
		{
			$this->getDb()->delete('t_newsletter', array('email' => $email));
		}
	}
?>