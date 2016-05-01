<?php
	require_once '../vendor/autoload.php';

	$app = new Silex\Application();

	require '../app/config/config.php';
	require '../app/app.php';
	require '../app/routes.php';

	$app->run();
?>
