<?php


namespace Vecnavium\CustomMessages;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase
{

    private $config;

    private static $instance = null;

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new Listeners($this), $this);
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->config = $this->getConfig()->getAll();
    }


    public function isJoinMessageEnabled() : bool {
        return $this->config["Join"]["Enabled"];
    }
    public function getJoinMessage(Player $player)
    {
        return TextFormat::colorize($this->replaceVars($this->config["Join"]["message"], array(
            "PLAYER" => $player->getName())));
    }


    public function isQuitMessageEnabled(){
        return $this->config["Quit"]["Enabled"];
    }
    public function getQuitMessage(Player $player){
        return TextFormat::colorize($this->replaceVars($this->config["Quit"]["message"], array(
            "PLAYER" => $player->getName())));
    }

    public function isWhitelistMessageEnabled() : bool {
        return $this->config["WhitelistedServer"]["Enabled"];
    }

    public function getWhitelistMessage(Player $player){
        return TextFormat::colorize($this->replaceVars($this->config["WhitelistedServer"]["message"], array(
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

