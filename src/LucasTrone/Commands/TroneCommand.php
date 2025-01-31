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
            $sender->sendMessage($this->plugin->getMessage("usage"));
            return true;
        }

        switch ($args[0]) {
            case "set":
                $this->plugin->addSelectingPlayer($sender);
                $sender->sendMessage($this->plugin->getMessage("point1_set"));
                break;

            case "remove":
                $this->plugin->removeZone();
                $sender->sendMessage($this->plugin->getMessage("zone_removed"));
                break;

            default:
                $sender->sendMessage($this->plugin->getMessage("usage"));
                break;
        }

        return true;
    }
}