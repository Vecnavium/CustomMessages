<?php


namespace Vecnavium\CustomMessages;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\lang\Language;

class Main extends PluginBase
{

	private $config;

	private static Language $language;

	private array $languages = ["eng", "vie"];

	public static function getLanguage(): Language
	{
		return self::$language;
	}

	protected function onEnable(): void
	{
		$this->getServer()->getPluginManager()->registerEvents(new Listeners($this), $this);
		$this->saveDefaultConfig();
		$this->config = $this->getConfig()->getAll();
		$this->initLanguageFiles($this->getConfig()->get("Language"), $this->languages);
	}

	public function initLanguageFiles(string $lang, array $languageFiles): void
	{
		if (!is_dir($this->getDataFolder() . "languages/")) {
			@mkdir($this->getDataFolder() . "languages/");
		}
		foreach ($languageFiles as $file) {
			if (!is_file($this->getDataFolder() . "languages/" . $file . ".languages")) {
				$this->saveResource("languages/" . $file . ".ini");
			}
		}
		self::$language = new Language($lang, $this->getDataFolder() . "languages/");
	}

	public function isJoinMessageEnabled(): bool
	{
		return $this->config["Join"]["Enabled"];
	}

	public function getJoinMessage(Player $player)
	{
		return TextFormat::colorize(
			$this->replaceVars(
				$this->getLanguage()->translateString("join.message"),
				array(
					"PLAYER" => $player->getName()
				)
			)
		);
	}

	public function isQuitMessageEnabled()
	{
		return $this->config["Quit"]["Enabled"];
	}

	public function getQuitMessage(Player $player)
	{
		return TextFormat::colorize(
			$this->replaceVars(
				$this->getLanguage()->translateString("quit.message"),
				array(
					"PLAYER" => $player->getName()
				)
			)
		);
	}

	public function isWhitelistMessageEnabled(): bool
	{
		return $this->config["WhitelistedServer"]["Enabled"];
	}

	public function getWhitelistMessage(Player $player)
	{
		return TextFormat::colorize(
			$this->replaceVars(
				$this->getLanguage()->translateString("whitelistedserver.message"),
				array(
					"PLAYER" => $player->getName()
				)
			)
		);
	}

	public function replaceVars($str, array $vars)
	{
		foreach ($vars as $key => $value) {
			$str = str_replace("{" . $key . "}", $value, $str);
		}
		return $str;
	}
}
