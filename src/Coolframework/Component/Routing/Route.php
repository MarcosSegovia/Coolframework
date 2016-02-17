<?php

namespace Coolframework\Component\Routing;

class Route
{
	private $name;
	private $associate_controller;

	public function __construct($a_name, $an_associate_controller)
	{
		$this->name = $a_name;
		$this->associate_controller = $an_associate_controller;
	}

	public static function register($a_name, $an_associate_controller)
	{
		return new self($a_name, $an_associate_controller);
	}

	public function associateController()
	{
		return $this->associate_controller;
	}

}