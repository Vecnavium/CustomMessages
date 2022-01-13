<?php

namespace Vecnavium\CustomMessages\EventManager;

use pocketmine\event\plugin\PluginEvent;

abstract class MainEventManager extends PluginEvent
{

	private $message;

	public function getMessage()
	{
		return $this->message;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}
}
