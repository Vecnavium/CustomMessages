<?php


namespace Vecnavium\CustomMessages\EventManager;

use pocketmine\player\Player;

class QuitEvent extends MainEventManager {
	

	private $player;
	public function __construct(Player $player){
		$this->player = $player;
	}
	public function getPlayer() : Player {
		return $this->player;
	}
}