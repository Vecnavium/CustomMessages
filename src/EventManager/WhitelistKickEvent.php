<?php

namespace Vecnavium\CustomMessages\EventManager;

use pocketmine\player\Player;

class WhitelistKickEvent extends MainEventManager
{

	private Player $player;

	public function __construct(Player $player)
	{
		$this->player = $player;
	}

	public function getPlayer(): Player
	{
		return $this->player;
	}
}
