<?php
	namespace LMQP\Manager;
	
	use LMQP\Domain\Message;
	
	class MessageManager
	{
		public function sendMessageByEmail(Message $m, $to, $copytosender=false)
		{
			$feedback = array(	 "success" => array(), 
								"warning" => array(), 
								"danger" => array());
			
			// check that every required field is correctly set
			foreach(Message::$required as $key => $val)
			{
				$get="get".ucfirst($key);
				if ($val && empty($m->$get()))
					$feedback['warning'][] = "Le champ '".Message::$translation[$key]."' doit être renseigné et conforme.";
			}
			if (count($feedback['warning'])>0)
				return $feedback;
				
			// build the Email
			$subject = "lamusiquequipetille.info : Message de " . $m->getFirstname() . " " . $m->getLastname();

			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/plain; charset=iso-8859-1";
			$headers[] = "From: Lamusiquequipetille <contact@lamusiquequipetille.info>";
// 			$headers[] = "Bcc: JJ Chong <bcc@domain2.com>";
			$headers[] = "Reply-To: ".$m->getFirstname()." ".$m->getLastname()." <".$m->getEmail().">";
			$headers[] = "Subject: {$subject}";
			$headers[] = "X-Mailer: PHP/".phpversion();			

			
			$content = $m->getMessage();
			$content .= "\r\n\r\nCoordonnées:";
			$content .= "\r\n" . $m->getFirstname() . " " . $m->getLastname();
			$content .= "\r\n" . $m->getEmail();
			if (!empty($m->getPhone()))
				$content .= "\r\nTél:" . $m->getPhone();
			
			if (mail($to, $subject, $content, implode("\r\n", $headers)))
			{
				$feedback['success'][] = "Message envoyé";
				if ($copytosender)
				{
					// build the copy
					$subject = "lamusiquequipetille.info : Message bien reçu !";
					$headers[3] = "Reply-To: Lamusiquequipetille <contact@lamusiquequipetille.info>";
					$headers[4] = "Subject: {$subject}";
					$content = "Bonjour ".$m->getFirstname()." ".$m->getLastname().", \r\nnous vous confirmons avoir bien reçu de votre part le message ci-après. Nous vous recontacterons dans les plus brefs délais.\r\n\r\nCordialement,\r\nLamusiquequipetille\r\n\r\n----------------\r\n\r\n" . $content;
					
					if (mail($m->getEmail(), $subject, $content, implode("\r\n", $headers)))
						$feedback['success'][0] .= ". Vous allez recevoir une confirmation à l'adresse ".$m->getEmail().".";
					else
						$feedback['success'][0] .= ". Echec de l'envoi de la confirmation à l'adresse ".$m->getEmail().".";
				}
			}
			else
				$feedback['danger'][] = "Echec de l'envoi du message.";

			return $feedback;
		}
		
		public function emptyMessage(Message $m)
		{
			foreach(Message::$required as $key => $val)
			{
				$set="set".ucfirst($key);
				$m->$set("");
			}
		}
	}
?>