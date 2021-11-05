<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Solid;
use pocketmine\item\TieredTool;

class PolishedBlackstoneBlock extends Solid {
    use PlaceholderTrait, MaterialStoneTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::POLISHED_BLACKSTONE, $meta, "Polished Blackstone");
    }

    public function getHardness(): float
    {
        return 2;
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }
}




