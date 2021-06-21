<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\BlockToolType;
use pocketmine\block\Solid;
use pocketmine\item\TieredTool;

class CrackedPolishedBlackstoneBricksBlock extends Solid {
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::CRACKED_POLISHED_BLACKSTONE_BRICKS, $meta, "Cracked Polished Blackstone Bricks");
    }

    public function getBlastResistance(): float
    {
        return 6;
    }

    public function getHardness(): float
    {
        return 1.5;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }
}






