<?php

declare(strict_types=1);

namespace DiamondStrider1\Disguise;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

class DisguiseCommand extends Command implements PluginOwned
{
    private Disguise $api;
    public function __construct(private Main $plugin)
    {
        parent::__construct("disguise", "Disguise or Remove Disguise", "disguise [player]");
        $this->api = Disguise::getInstance();
        $this->setPermission("disguise.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Run this command as a player!");
            return;
        }

        $playerName = array_shift($args);
        if ($playerName) {
            if (!$other = $sender->getServer()->getPlayerByPrefix($playerName)) {
                $sender->sendMessage("That player is not online!");
                return;
            }
            $sender->sendMessage("Disguising you as " . $other->getName() . ".");
            $this->api->disguise($sender, Cloak::fromPlayer($other));
            return;
        }

        if ($this->api->isDisguised($sender)) {
            $sender->sendMessage("Removing your disguise.");
            $this->api->removeDisguise($sender);
        } else {
            $sender->sendMessage("You don't have a disguise on!");
        }
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}
