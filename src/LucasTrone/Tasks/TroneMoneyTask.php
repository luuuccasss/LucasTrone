<?php
namespace LucasTrone\Tasks;

use pocketmine\scheduler\Task;
use LucasTrone\Main;
use LucasEconomy\API\LucasEconomyAPI;

class TroneMoneyTask extends Task {

    /** @var Main $plugin */
    private $plugin;

    /** @var LucasEconomyAPI $economyAPI */
    private $economyAPI;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->economyAPI = new LucasEconomyAPI($plugin->getServer()->getPluginManager()->getPlugin("LucasEconomy"));
    }

    public function onRun(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $pos = $player->getPosition();

            if ($this->plugin->isInZone($pos->getX(), $pos->getY(), $pos->getZ())) {
                $amount = $this->plugin->getMoneyPerInterval();
                $this->economyAPI->addMoney($player, $amount);

                $player->sendPopup($this->plugin->getMessage("trone_money", [
                    "amount" => $amount,
                ]));
            }
        }
    }
}