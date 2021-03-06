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

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable(): void
    {
        $cm = $this->getServer()->getCommandMap();
        $cm->register("disguise", new DisguiseCommand($this), "disguise");
    }
}
