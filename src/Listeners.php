<?php

namespace Vecnavium\CustomMessages;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\Server;
use Vecnavium\CustomMessages\EventManager\JoinEvent;
use Vecnavium\CustomMessages\EventManager\QuitEvent;
use Vecnavium\CustomMessages\EventManager\WhitelistKickEvent;

class Listeners implements Listener
{

	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	public function onPlayerJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$aevent = new JoinEvent($player);
		if ($this->plugin->isJoinMessageEnabled()) {
			$aevent->setMessage($this->plugin->getJoinMessage($player));
		} else {
			$aevent->setMessage($event->getJoinMessage());
		}
		$this->plugin->getServer()->getPluginManager($aevent);
		$event->setJoinMessage($aevent->getMessage());
	}


	public function onPlayerQuit(PlayerQuitEvent $event)
	{
		$player = $event->getPlayer();
		$aevent = new QuitEvent($player);
		if ($this->plugin->isQuitMessageEnabled()) {
			$aevent->setMessage($this->plugin->getQuitMessage($player));
		} else {
			$aevent->setMessage($event->getQuitMessage());
		}
		$this->plugin->getServer()->getPluginManager($aevent);
		$event->setQuitMessage($aevent->getMessage());
	}

	public function onPlayerLogin(PlayerLoginEvent $event)
	{
		$player = $event->getPlayer();
		if (count($this->plugin->getServer()->getOnlinePlayers()) - 1 < $this->plugin->getServer()->getMaxPlayers()) {
			if (!$this->plugin->getServer()->isWhitelisted($player->getName())) {
				$cevent = new WhitelistKickEvent($player);
				if ($this->plugin->isWhitelistMessageEnabled()) {
					$cevent->setMessage($this->plugin->getWhitelistMessage($player));
				}
				$this->plugin->getServer()->getPluginManager()->callEvent($cevent);
				if ($cevent->getMessage() != "") {
					$player->close("", $cevent->getMessage());
					$event->setCancelled(true);
				}
			}
		}
	}
}
