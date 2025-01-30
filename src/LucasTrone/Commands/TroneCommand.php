<?php

namespace LucasTrone\Commands;

use LucasTrone\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class TroneCommand extends Command {

    /** @var Main $plugin */
    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("trone", "Définir la zone du trône", "/trone <set1|set2>");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Cette commande doit être exécutée par un joueur.");
            return true;
        }

        if (isset($args[0])) {
            switch ($args[0]) {
                case "set1":
                    $pos = $sender->getPosition();
                    $this->plugin->setZonePoint(1, $pos->getX(), $pos->getY(), $pos->getZ());
                    $sender->sendMessage("Point 1 de la zone défini à " . $pos->getX() . ", " . $pos->getY() . ", " . $pos->getZ());
                    break;
                case "set2":
                    $pos = $sender->getPosition();
                    $this->plugin->setZonePoint(2, $pos->getX(), $pos->getY(), $pos->getZ());
                    $sender->sendMessage("Point 2 de la zone défini à " . $pos->getX() . ", " . $pos->getY() . ", " . $pos->getZ());
                    break;
                default:
                    $sender->sendMessage("Usage: /trone <set1|set2>");
                    break;
            }
        } else {
            $sender->sendMessage("Usage: /trone <set1|set2>");
        }
        return true;
    }
}