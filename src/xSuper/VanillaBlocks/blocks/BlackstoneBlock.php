<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Solid;
use pocketmine\item\TieredTool;

class BlackstoneBlock extends Solid {
    use PlaceholderTrait, MaterialStoneTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::BLACKSTONE, $meta, "Blackstone");
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }
}



