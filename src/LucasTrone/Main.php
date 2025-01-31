<?php

namespace LucasTrone;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use LucasTrone\Commands\TroneCommand;
use LucasTrone\Events\BlockBreakListener;
use LucasTrone\Events\PlayerMoveListener;
use LucasTrone\Tasks\TroneMoneyTask;

class Main extends PluginBase {
    private array $zone = [];
    private $config;
    private array $selectingPlayers = [];
    private array $messages = [];
    private int $moneyPerInterval;
    private int $intervalSeconds;
    private int $messageCooldown;
    private array $inZonePlayers = [];
    private array $lastMessageTimestamps = [];
    private array $lastLeaveTimestamps = [];

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->zone = $this->config->get("zone", []);
        $this->messages = $this->getConfig()->get("messages", []);
        $this->moneyPerInterval = $this->getConfig()->getNested("settings.money_per_interval", 10);
        $this->intervalSeconds = $this->getConfig()->getNested("settings.interval_seconds", 5);
        $this->messageCooldown = $this->getConfig()->getNested("settings.message_cooldown", 10);
        $this->getScheduler()->scheduleRepeatingTask(new TroneMoneyTask($this), $this->intervalSeconds * 20);
        $this->getServer()->getCommandMap()->register("lucastrone", new TroneCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new BlockBreakListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerMoveListener($this), $this);
    }
    public function getZone(): array {
        return $this->zone;
    }
    public function removeZone(): void {
        $this->getConfig()->set("zone", null);
        $this->getConfig()->save();
        $this->zone = [];
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
    public function getMessage(string $key, array $replacements = []): string {
        $message = $this->messages[$key] ?? "§cMessage not found : " . $key;
        foreach ($replacements as $placeholder => $value) {
            $message = str_replace("{" . $placeholder . "}", $value, $message);
        }
        return $message;
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
    public function getMoneyPerInterval(): int {
        return $this->moneyPerInterval;
    }
    public function getIntervalSeconds(): int {
        return $this->intervalSeconds;
    }
    public function getMessageCooldown(): int {
        return $this->messageCooldown;
    }
    public function canSendMessage(Player $player): bool {
        $name = $player->getName();
        $now = time();

        if (!isset($this->lastMessageTimestamps[$name])) {
            $this->lastMessageTimestamps[$name] = $now;
            return true;
        }

        if ($now - $this->lastMessageTimestamps[$name] >= $this->messageCooldown) {
            $this->lastMessageTimestamps[$name] = $now;
            return true;
        }

        return false;
    }

    public function canSendLeaveMessage(Player $player): bool {
        $name = $player->getName();
        $now = time();

        if (!isset($this->lastLeaveTimestamps[$name])) {
            $this->lastLeaveTimestamps[$name] = $now;
            return true;
        }

        if ($now - $this->lastLeaveTimestamps[$name] >= $this->messageCooldown) {
            $this->lastLeaveTimestamps[$name] = $now;
            return true;
        }

        return false;
    }

    public function setPlayerInZone(Player $player): void {
        $this->inZonePlayers[$player->getName()] = true;
    }
    public function setPlayerLeftZone(Player $player): void {
        unset($this->inZonePlayers[$player->getName()]);
    }
    public function isPlayerInZone(Player $player): bool {
        return isset($this->inZonePlayers[$player->getName()]);
    }
}