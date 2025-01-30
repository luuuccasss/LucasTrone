<?php

namespace LucasTrone;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use LucasTrone\Commands\TroneCommand;
use LucasTrone\Events\BlockBreakListener;
use LucasTrone\Events\PlayerMoveListener;

class Main extends PluginBase {

    /** @var array $zone */
    private $zone = [];

    /** @var Config $config */
    private $config;

    /** @var array $selectingPlayers */
    private $selectingPlayers = [];

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->zone = $this->config->get("zone", []);

        // Enregistrer la commande
        $this->getServer()->getCommandMap()->register("lucastrone", new TroneCommand($this));

        // Enregistrer les événements
        $this->getServer()->getPluginManager()->registerEvents(new BlockBreakListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerMoveListener($this), $this);
    }

    public function getZone(): array {
        return $this->zone;
    }

    public function setZonePoint(int $point, float $x, float $y, float $z): void {
        $this->zone["point$point"] = ["x" => $x, "y" => $y, "z" => $z];
        $this->config->set("zone", $this->zone);
        $this->config->save();
    }

    public function isInZone(float $x, float $y, float $z): bool {
        if (count($this->zone) < 2) {
            return false;
        }

        $point1 = $this->zone["point1"];
        $point2 = $this->zone["point2"];

        $minX = min($point1["x"], $point2["x"]);
        $maxX = max($point1["x"], $point2["x"]);
        $minY = min($point1["y"], $point2["y"]);
        $maxY = max($point1["y"], $point2["y"]);
        $minZ = min($point1["z"], $point2["z"]);
        $maxZ = max($point1["z"], $point2["z"]);

        return $x >= $minX && $x <= $maxX && $y >= $minY && $y <= $maxY && $z >= $minZ && $z <= $maxZ;
    }

    public function addSelectingPlayer(Player $player): void {
        $this->selectingPlayers[$player->getName()] = true;
    }

    public function isSelectingPlayer(Player $player): bool {
        return isset($this->selectingPlayers[$player->getName()]);
    }

    public function removeSelectingPlayer(Player $player): void {
        unset($this->selectingPlayers[$player->getName()]);
    }
}