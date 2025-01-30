<?php

namespace LucasTrone\Events;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\player\Player;
use LucasTrone\Main;

class BlockBreakListener implements Listener {

    /** @var Main $plugin */
    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onBlockBreak(BlockBreakEvent $event): void {
        $player = $event->getPlayer();

        if ($this->plugin->isSelectingPlayer($player)) {
            $event->cancel();
            $block = $event->getBlock();
            $pos = $block->getPosition();

            if (!isset($this->plugin->getZone()["point1"])) {
                $this->plugin->setZonePoint(1, $pos->getX(), $pos->getY(), $pos->getZ());
                $player->sendMessage("§aPoint 1 défini à " . $pos->getX() . ", " . $pos->getY() . ", " . $pos->getZ());
                $player->sendMessage("§aTapez un autre bloc pour définir le point 2.");
            } else {
                $this->plugin->setZonePoint(2, $pos->getX(), $pos->getY(), $pos->getZ());
                $player->sendMessage("§aPoint 2 défini à " . $pos->getX() . ", " . $pos->getY() . ", " . $pos->getZ());
                $player->sendPopup("§aLa zone du trone est set.");
                $this->plugin->removeSelectingPlayer($player);
            }
        }
    }
}