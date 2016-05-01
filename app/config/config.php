<?php
	$config = array();
	$config_file = "config.ini";
	if (file_exists("../app/config/".$config_file))
		$config = parse_ini_file($config_file, true);
	else
		die ("Error: Config file missing !");

	if (array_key_exists('db', $config))
	{
		$list_of_keys = array('driver', 'charset', 'host', 'port', 'dbname', 'user', 'password');
		foreach($list_of_keys as $key)
			if (!array_key_exists($key, $config['db']))
				die("Error: config file must contain: '".$key."' data.");

		$app['db.options'] = $config['db'];
	}
	else
		die("Error: database config not set");


	if (array_key_exists('debug', $config))
	{
		if ($config['debug']['active'])
		{
			// enable the debug mode
			$app['debug'] = true;

			// active PHP errors
			error_reporting(E_ALL);
			ini_set("display_errors", 1);
		}
		else
		{
			$app['debug'] = false;
			ini_set("display_errors", 0);
			
			// register error service -- To activate at the end
			$app->error(function (\Exception $e, $code) use ($app)
			{
				$menu = 
							array(	"home" => "", 
									"prog" => "",
									"histo" => "",
									"booking" => "",
									"infos" => "",
									"part" => "",
							);

				switch ($code)
				{
					case 403:
		// 				$message = 'Access denied.';
						$message = 'Accès interdit.';
						break;
					case 404:
		// 				$message = 'The requested resource could not be found.';
						$message = 'La page demandée n\'a pas été trouvée !';
						break;
					default:
		// 				$message = 'Something went wrong';
						$message = 'Quelque chose s\'est mal passé...';
				}
				return $app['twig']->render('error.html.twig', array('message' => $message, 'code' => $code, 'menu' => $menu));
			});

		}
	}
?>
