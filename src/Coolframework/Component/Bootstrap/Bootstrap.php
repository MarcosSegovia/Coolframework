<?php

namespace Coolframework\Component\Bootstrap;

use Coolframework\Component\Routing\Routing;
use Symfony\Component\Yaml\Parser;

class Bootstrap
{
	public function __construct()
	{
		echo "Hello, I'm the Coolframework";
	}

	public function configRouting($routing_to_config_file)
	{
		$routing = new Routing();
		$routing->setRoutingDirectory($routing_to_config_file);
	}
}