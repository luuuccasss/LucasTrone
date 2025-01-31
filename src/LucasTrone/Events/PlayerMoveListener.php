<?php

namespace LucasTrone\Events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use LucasTrone\Main;

class PlayerMoveListener implements Listener
{

    /** @var Main $plugin */
    private $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $pos = $player->getPosition();

        if ($this->plugin->isInZone($pos->getX(), $pos->getY(), $pos->getZ())) {
            if (!$this->plugin->isPlayerInZone($player)) {
                $this->plugin->setPlayerInZone($player);

                if ($this->plugin->canSendMessage($player)) {
                    $this->plugin->getServer()->broadcastMessage($this->plugin->getMessage("trone_enter", [
                        "player" => $player->getName(),
                    ]));
                }
            }
        } else {
            if ($this->plugin->isPlayerInZone($player)) {
                $this->plugin->setPlayerLeftZone($player);

                $this->plugin->getServer()->broadcastMessage($this->plugin->getMessage("trone_leave", [
                    "player" => $player->getName(),
                ]));
            }
        }
    }
}