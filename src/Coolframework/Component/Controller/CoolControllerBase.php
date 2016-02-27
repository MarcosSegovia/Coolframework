<?php

namespace Coolframework\Component\Controller;

use Coolframework\Component\Injector\CoolContainer;

abstract class CoolControllerBase
{
	protected $container;

	public function __construct(CoolContainer $container)
	{
		$this->container = $container;
	}
}