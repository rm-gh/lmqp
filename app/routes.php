<?php
	use Symfony\Component\HttpFoundation\Request;

	// home page
	$app->get('/', "LMQP\Controller\HomeController::indexAction")->bind('home');

	// programmation page
	$app->get('/prog/', "LMQP\Controller\HomeController::programmeAction")->bind('prog');
	// booking page
	$app->match('/booking/', "LMQP\Controller\HomeController::bookingAction")->bind('booking');
	// history page
	$app->get('/histo/', "LMQP\Controller\HomeController::historyAction")->bind('histo');
	// useful information page
	$app->get('/infos/', "LMQP\Controller\HomeController::informationAction")->bind('infos');
	// partner page
	$app->get('/part/', "LMQP\Controller\HomeController::partnerAction")->bind('part');
	// press page
	$app->get('/press/', "LMQP\Controller\HomeController::incomingAction")->bind('press');
	// contact page
	$app->match('/contact/', "LMQP\Controller\HomeController::contactAction")->bind('contact');
?>
