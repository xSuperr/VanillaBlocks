<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Transparent;

class BarrierBlock extends Transparent {
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::BARRIER, $meta, "Barrier");
    }

    public function getBlastResistance(): float
    {
        return 3600000.8;
    }

    public function getHardness(): float
    {
        return -1;
    }
}


