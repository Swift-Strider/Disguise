<?php

declare(strict_types=1);

namespace DiamondStrider1\Disguise;

use pocketmine\entity\Skin;
use pocketmine\player\Player;

class Cloak
{
    public static function fromPlayer(Player $player): self
    {
        return new self(
            $player->getSkin(),
            $player->getNameTag(),
            $player->getDisplayName(),
        );
    }

    public function __construct(
        private Skin $skin,
        private string $nameTag,
        private string $displayName,
    ) {
    }

    public function apply(Player $player)
    {
        $player->setSkin($this->skin);
        $player->sendSkin();
        $player->setNameTag($this->nameTag);
        $player->setDisplayName($this->displayName);
    }
}
