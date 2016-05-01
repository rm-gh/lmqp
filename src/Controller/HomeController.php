<?php
	namespace LMQP\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use LMQP\Domain\Message;
	use LMQP\Form\Type\MessageType;
	use LMQP\Manager\MessageManager;
	use LMQP\Domain\Newsletter;
	use LMQP\Form\Type\NewsletterType;
	use LMQP\Domain\Booking;
	use LMQP\Form\Type\BookingType;
	use LMQP\Manager\BookingManager;
	
	class HomeController
	{
		private	$menu = 
					array(	"home" => "", 
							"prog" => "",
							"histo" => "",
							"booking" => "",
							"infos" => "",
							"part" => "",
					);
		public function indexAction(Application $app)
		{
			$this->menu['home'] = "active";
			return $app['twig']->render('index.html.twig', array("menu" => $this->menu));
		}
		
		public function incomingAction(Application $app)
		{
			return $app['twig']->render('incoming.html.twig', array("menu" => $this->menu));
		}
		
		public function contactAction(Application $app, Request $request)
		{
			$message = new Message();
			$messageForm = $app['form.factory']->create(new MessageType(), $message);
			$newMessageForm = $app['form.factory']->create(new MessageType(), new Message);
			$messageForm->handleRequest($request);
			
			if ($messageForm->isSubmitted() && $messageForm->isValid())
			{
				$mm = new MessageManager();
				$ret = $mm->sendMessageByEmail($message, "contact@lamusiquequipetille.info", true);
			
				foreach($ret['danger'] as $value)
					$app['session']->getFlashBag()->add('danger', $value);
				foreach($ret['warning'] as $value)
					$app['session']->getFlashBag()->add('warning', $value);
				foreach($ret['success'] as $value)
					$app['session']->getFlashBag()->add('success', $value);
					
			}
			
			$newsletter = new Newsletter();
			$newsletterForm = $app['form.factory']->create(new NewsletterType(), $newsletter);
			$newNewsletterForm = $app['form.factory']->create(new NewsletterType(), new Newsletter);
			$newsletterForm->handleRequest($request);
			
			if ($newsletterForm->isSubmitted() && $newsletterForm->isValid())
			{
				if ($newsletter->getEmail())	
				{
					$newsletter->setActive(true);
					$app['dao.newsletter']->save($newsletter);
					$app['session']->getFlashBag()->add('success', "Votre adresse a bien été enregistrée. Merci pour votre intérêt.");
				}
				else
					$app['session']->getFlashBag()->add('danger', "L'adresse e-mail saisie est invalide.");

			}
			
		
			if (!$app['session']->getFlashBag()->has('danger') && !$app['session']->getFlashBag()->has('warning'))
				return $app['twig']->render('contact.html.twig', array(
					"menu" => $this->menu, 
					"messageForm" => $newMessageForm->createView(), 
					"messageInfo" => Message::$validationMessage,
					"newsletterForm" => $newNewsletterForm->createView(),
					"newsletterInfo" => Newsletter::$validationNewsletter
					));
			else
				return $app['twig']->render('contact.html.twig', array(
					"menu" => $this->menu, 
					"messageForm" => $messageForm->createView(), 
					"messageInfo" => Message::$validationMessage,
					"newsletterForm" => $newsletterForm->createView(),
					"newsletterInfo" => Newsletter::$validationNewsletter
					));
		}
		
		public function bookingAction(Application $app, Request $request)
		{
			$this->menu['booking'] = "active";
			
			$booking = new Booking();
			$bookingForm = $app['form.factory']->create(new BookingType(), $booking);
			$newBookingForm = $app['form.factory']->create(new BookingType(), new Booking);
			$bookingForm->handleRequest($request);
			
			if ($bookingForm->isSubmitted() && $bookingForm->isValid())
			{
				if ($booking->isComplete())
				{
					$bm = new BookingManager();
					if ($bm->sendBookingByEmail($booking, "booking@lamusiquequipetille.info", true))
						$app['session']->getFlashBag()->add('success','Votre demande a bien été prise en compte. Nous vous recontacterons bientôt pour confirmer votre réservation.');
					else
						$app['session']->getFlashBag()->add('danger','Echec de la réservation');
				}
				else
					$app['session']->getFlashBag()->add('danger','Erreur dans votre demande de réservation. Vérifiez vos informations.');
			}
			
			if (!$app['session']->getFlashBag()->has('danger') && !$app['session']->getFlashBag()->has('warning'))
				return $app['twig']->render('booking.html.twig', array(
					"menu" => $this->menu,
					"bookingForm" => $newBookingForm->createView(),
					"bookingInfo" => Booking::$validationBooking
					));
			else
				return $app['twig']->render('booking.html.twig', array(
					"menu" => $this->menu,
					"bookingForm" => $bookingForm->createView(),
					"bookingInfo" => Booking::$validationBooking
					));
		}
	}