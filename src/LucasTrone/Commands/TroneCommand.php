<?php

namespace LucasTrone\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use LucasTrone\Main;

class TroneCommand extends Command {

    /** @var Main $plugin */
    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("trone", "Définir ou supprimer la zone du trône", "/trone <set|remove>");
        $this->setPermission("lucastrone.set");

        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Cette commande doit être exécutée par un joueur.");
            return true;
        }

        if (!isset($args[0])) {
            $sender->sendMessage("Usage: /trone <set|remove>");
            return true;
        }

        switch ($args[0]) {
            case "set":
                $this->plugin->addSelectingPlayer($sender);
                $sender->sendMessage("§aTapez un bloc pour définir le point 1 de la zone.");
                break;

            case "remove":
                $this->plugin->removeZone();
                $sender->sendMessage("§aLa zone du trône a été supprimée.");
                break;

            default:
                $sender->sendMessage("Usage: /trone <set|remove>");
                break;
        }

        return true;
    }
}