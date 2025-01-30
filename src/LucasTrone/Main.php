<?php

namespace LucasTrone;

use LucasTrone\Commands\TroneCommand;
use LucasTrone\Events\PlayerMoveListener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    /** @var array $zone */
    private $zone = [];

    /** @var Config $config */
    private $config;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->zone = $this->config->get("zone", []);

        // Enregistrer la commande
        $this->getServer()->getCommandMap()->register("lucastrone", new TroneCommand($this));

        // Enregistrer l'événement
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
}