<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\BlockToolType;
use pocketmine\block\Solid;

class SoulSoilBlock extends Solid {
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::SOUL_SOIL, $meta, "Soul Soil");
    }

    public function getBlastResistance(): float
    {
        return 4.2;
    }

    public function getHardness(): float
    {
        return 1.25;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_SHOVEL;
    }
}


