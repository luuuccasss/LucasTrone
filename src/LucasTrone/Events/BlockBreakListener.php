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

            $zone = $this->plugin->getZone();

            $player->sendMessage("§eDebug: Zone actuelle: " . print_r($zone, true));

            if (!isset($zone["point1"])) {
                $this->plugin->setZonePoint(1, $pos->getX(), $pos->getY(), $pos->getZ());
                $player->sendMessage("§aPoint 1 défini à " . $pos->getX() . ", " . $pos->getY() . ", " . $pos->getZ());
                $player->sendMessage("§aTapez un autre bloc pour définir le point 2.");

                $zone = $this->plugin->getZone();
                $player->sendMessage("§eDebug: Zone après définition du point 1: " . print_r($zone, true));
            }
            elseif (!isset($zone["point2"])) {
                $this->plugin->setZonePoint(2, $pos->getX(), $pos->getY(), $pos->getZ());
                $player->sendMessage("§aPoint 2 défini à " . $pos->getX() . ", " . $pos->getY() . ", " . $pos->getZ());
                $player->sendPopup("§aLa zone du trône est définie.");

                $this->plugin->removeSelectingPlayer($player);

                $zone = $this->plugin->getZone();
                $player->sendMessage("§eDebug: Zone après définition du point 2: " . print_r($zone, true));
            }
            else {
                $player->sendMessage("§cLes deux points sont déjà définis.");
            }
        }
    }
}