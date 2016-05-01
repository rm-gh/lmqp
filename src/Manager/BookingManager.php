<?php
	namespace LMQP\Manager;
	
	use LMQP\Domain\Booking;
	
	class BookingManager
	{
		public function sendBookingByEmail(Booking $b, $to, $copytosender=false)
		{
			// at this point, everything is normally already checked. So we don't do it again..
			
			// build the Email
			$subject = "lamusiquequipetille.info : Demande de réservation de " . $b->getFirstname() . " " . $b->getLastname();

			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/plain; charset=iso-8859-1";
			$headers[] = "From: Lamusiquequipetille <contact@lamusiquequipetille.info>";
// 			$headers[] = "Bcc: JJ Chong <bcc@domain2.com>";
			$headers[] = "Reply-To: ".$b->getFirstname()." ".$b->getLastname()." <".$b->getEmail().">";
			$headers[] = "Subject: {$subject}";
			$headers[] = "X-Mailer: PHP/".phpversion();			

			
			$content = "Coordonnées:";
			$content .= "\r\n" . $b->getFirstname() . " " . $b->getLastname();
			$content .= "\r\n" . $b->getAddress();
			$content .= "\r\n" . $b->getEmail();
			$content .= "\r\nTél:" . $b->getPhone();
			$content .= "\r\n\r\nActivité : " . $b->getActivity();
			$content .= "\r\n\r\nCette personne souhaite réserver un emplacement pour la bourse. Elle a été prévenue de la réception de sa demande par nos services.";
			
			if (mail($to, $subject, $content, implode("\r\n", $headers)))
			{
				if ($copytosender)
				{
					// build the copy
					$subject = "lamusiquequipetille.info : Demande de réservation bien reçue !";
					$headers[3] = "Reply-To: Lamusiquequipetille <contact@lamusiquequipetille.info>";
					$headers[4] = "Subject: {$subject}";
					$content = "Bonjour ".$b->getFirstname()." ".$b->getLastname().", \r\nnous vous confirmons avoir bien reçu votre demande de réservation. Nous vous recontacterons dans les plus brefs délais afin d'y donner suite.\r\n\r\nCordialement,\r\nLamusiquequipetille";
					
					mail($b->getEmail(), $subject, $content, implode("\r\n", $headers));

					return true;
				}
			}
			return false;
		}
	}
?>