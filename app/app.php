<?php
	use Symfony\Component\Debug\ErrorHandler;
	use Symfony\Component\Debug\ExceptionHandler;
// 	use Symfony\Component\HttpFoundation\Request;

	// register global error and exception handlers
	ErrorHandler::register();
	ExceptionHandler::register();

	// register service providers
	$app->register(new Silex\Provider\DoctrineServiceProvider());
	$app->register(new Silex\Provider\TwigServiceProvider(),
		array('twig.path' => '../views'));
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

	$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app)
	{
		$twig->addExtension(new Twig_Extensions_Extension_Text());
		return $twig;
	}));

	$app->register(new Silex\Provider\ValidatorServiceProvider());
	$app->register(new Silex\Provider\SessionServiceProvider());
	$app->register(new Silex\Provider\FormServiceProvider());
	$app->register(new Silex\Provider\TranslationServiceProvider());
	$app->register(new Silex\Provider\ServiceControllerServiceProvider());
	
	$app['dao.newsletter'] = $app->share(function ($app)
	{
		return new LMQP\DAO\NewsletterDAO($app['db']);
	});

	
?>
