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
        parent::__construct("trone", "Définir la zone du trône", "/trone set");
        $this->setPermission("lucastrone.set");

        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Cette commande doit être exécutée par un joueur.");
            return true;
        }

        if (isset($args[0]) && $args[0] === "set") {
            $this->plugin->addSelectingPlayer($sender);
            $sender->sendMessage("Tapez un bloc pour définir le point 1 de la zone.");
        } else {
            $sender->sendMessage("Usage: /trone set");
        }
        return true;
    }
}