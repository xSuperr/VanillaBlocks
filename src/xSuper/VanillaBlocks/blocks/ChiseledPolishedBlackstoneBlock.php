<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Solid;
use pocketmine\item\TieredTool;

class ChiseledPolishedBlackstoneBlock extends Solid {
    use PlaceholderTrait, MaterialStoneTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::CHISELED_POLISHED_BLACKSTONE, $meta, "Chiseled Polished Blackstone");
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }
}





