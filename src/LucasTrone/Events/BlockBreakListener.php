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

            if (!isset($zone["point1"])) {
                $this->plugin->setZonePoint(1, $pos->getX(), $pos->getY(), $pos->getZ());
                $player->sendMessage($this->plugin->getMessage("point1_set", [
                    "x" => $pos->getX(),
                    "y" => $pos->getY(),
                    "z" => $pos->getZ(),
                ]));
                $player->sendMessage($this->plugin->getMessage("point2_set"));
            }
            elseif (!isset($zone["point2"])) {
                $this->plugin->setZonePoint(2, $pos->getX(), $pos->getY(), $pos->getZ());
                $player->sendMessage($this->plugin->getMessage("point2_set", [
                    "x" => $pos->getX(),
                    "y" => $pos->getY(),
                    "z" => $pos->getZ(),
                ]));
                $player->sendPopup($this->plugin->getMessage("zone_defined"));

                $this->plugin->removeSelectingPlayer($player);
            }
            else {
                $player->sendMessage($this->plugin->getMessage("already_defined"));
            }
        }
    }
}