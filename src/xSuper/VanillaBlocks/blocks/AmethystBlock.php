<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\item\TieredTool;

class AmethystBlock extends Transparent {
    use PlaceholderTrait;

    // TODO: Unmapped ID
    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::AMETHYST, $meta, "Amethyst");
    }

    public function getBlastResistance(): float
    {
        return 1.5;
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



