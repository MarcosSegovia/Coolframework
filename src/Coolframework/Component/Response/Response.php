<?php

namespace Coolframework\Component\Response;

class Response
{
	private $message;

	public function __construct($a_message)
	{
		$this->message = $a_message;
	}

	public function message()
	{
		echo $this->message;
	}
}