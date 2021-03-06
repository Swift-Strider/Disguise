<?php

/**
 * Copyright 2022 DiamondStrider1

 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or sell copies of the
 * Software, and to permit persons to whom the Software is furnished to
 * do so, subject to the following conditions:

 * The above copyright notice and this permission notice shall
 * be included in all copies or substantial portions of the Software.
 */

declare(strict_types=1);

namespace DiamondStrider1\Disguise;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\world\particle\MobSpawnParticle;

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
            $this->doParticles($sender);
            $this->api->disguise($sender, Cloak::fromPlayer($other));
            return;
        }

        if ($this->api->isDisguised($sender)) {
            $sender->sendMessage("Removing your disguise.");
            $this->doParticles($sender);
            $this->api->removeDisguise($sender);
        } else {
            $sender->sendMessage("You don't have a disguise on!");
        }
    }

    private function doParticles(Player $player): void
    {
        $pos = $player->getPosition();
        $p = new MobSpawnParticle(2, 3);
        $world = $player->getWorld();
        $world->addParticle($pos, $p, [$player]);
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}
