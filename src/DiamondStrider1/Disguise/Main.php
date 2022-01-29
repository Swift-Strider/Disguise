<?php

declare(strict_types=1);

namespace DiamondStrider1\Disguise;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable(): void
    {
        $cm = $this->getServer()->getCommandMap();
        $cm->register("disguise", new DisguiseCommand($this), "disguise");
    }
}
