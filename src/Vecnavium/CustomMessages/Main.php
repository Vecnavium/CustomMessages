<?php


namespace Vecnavium\CustomMessages;

use pocketmine\player\Player;
use pocketmine\entity\Living;
use pocketmine\level\Level;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase
{

    private $config;

    private static $instance = null;


    public function onLoad(): void
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->config = $this->getConfig()->getAll();
    }

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new Listeners($this), $this);
    }

    public function isJoinMessageEnabled() : bool {
        return $this->config["Join"]["Enabled"];
    }
    public function isJoinMessageDisabled(): bool
    {
        return $this->config["Join"]["Disabled"];
    }
    public function getJoinMessage(Player $player)
    {
        return TextFormat::colorize($this->replaceVars($this->config["Join"]["message"], array(
            "PLAYER" => $player->getName())));
    }


    public function isQuitMessageEnabled(){
        return $this->config["Quit"]["Enabled"];
    }
    public function isQuitMessageDisabled()
    {
        return $this->config["Quit"]["Disabled"];
    }
    public function getQuitMessage(Player $player){
        return TextFormat::colorize($this->replaceVars($this->config["Quit"]["message"], array(
            "PLAYER" => $player->getName())));
    }


    public function replaceVars($str, array $vars)
    {
        foreach ($vars as $key => $value) {
            $str = str_replace("{" . $key . "}", $value, $str);
        }
        return $str;
    }
}

