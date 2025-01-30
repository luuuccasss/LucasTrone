<?php

namespace LucasTrone\Events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use LucasTrone\Main;
use LucasEconomy\API\LucasEconomyAPI;

class PlayerMoveListener implements Listener {

    /** @var Main $plugin */
    private $plugin;

    /** @var LucasEconomyAPI $economyAPI */
    private $economyAPI;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->economyAPI = new LucasEconomyAPI($plugin->getServer()->getPluginManager()->getPlugin("LucasEconomy"));
    }

    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $pos = $player->getPosition();

        if ($this->plugin->isInZone($pos->getX(), $pos->getY(), $pos->getZ())) {
            $this->economyAPI->addMoney($player, 10);
            $player->sendMessage("§aVous gagnez de l'argent en restant dans la zone du trône !");
        }
    }
}