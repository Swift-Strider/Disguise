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
