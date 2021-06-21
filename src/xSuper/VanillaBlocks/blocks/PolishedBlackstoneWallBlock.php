<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\item\TieredTool;

class PolishedBlackstoneWallBlock extends Transparent{
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::POLISHED_BLACKSTONE_WALL, $meta, "Polished Blackstone Wall");
    }

    public function getToolType() : int{
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

    public function getHardness() : float{
        return 2;
    }

    public function getBlastResistance(): float
    {
        return 6;
    }

    // Unfortunately walls dont connect in PocketMine (I also checked Nukkit, its the same thing)
}

