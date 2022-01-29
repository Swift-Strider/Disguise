<?php

declare(strict_types=1);

namespace DiamondStrider1\Disguise;

use pocketmine\player\Player;

class Disguise
{
    private static self $instance;
    public static function getInstance(): self
    {
        return self::$instance ??= new self;
    }

    /** @var array<string, Cloak> uuid => skinBeforeDisguising */
    private array $disguisedCloaks;

    public function disguise(Player $player, Cloak $cloak): void
    {
        $uuid = $player->getUniqueId()->getHex()->toString();
        $this->disguisedCloaks[$uuid] ??= Cloak::fromPlayer($player);
        $cloak->apply($player);
    }

    public function removeDisguise(Player $player): void
    {
        $uuid = $player->getUniqueId()->getHex()->toString();
        if (isset($this->disguisedCloaks[$uuid])) {
            $this->disguisedCloaks[$uuid]->apply($player);
            unset($this->disguisedCloaks[$uuid]);
        }
    }

    public function isDisguised(Player $player): bool
    {
        $uuid = $player->getUniqueId()->getHex()->toString();
        return isset($this->disguisedCloaks[$uuid]);
    }
}
