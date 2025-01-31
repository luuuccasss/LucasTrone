<?php

namespace LucasTrone\Events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use LucasTrone\Main;

class PlayerMoveListener implements Listener {

    /** @var Main $plugin */
    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $pos = $player->getPosition();

        if ($this->plugin->isInZone($pos->getX(), $pos->getY(), $pos->getZ())) {
            $this->plugin->getServer()->broadcastMessage($this->plugin->getMessage("trone_enter", [
                "player" => $player->getName(),
            ]));
        }
    }
}