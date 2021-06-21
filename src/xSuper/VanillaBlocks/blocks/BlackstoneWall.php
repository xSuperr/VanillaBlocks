<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\block\FenceGate;
use pocketmine\block\Transparent;
use pocketmine\item\TieredTool;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class BlackstoneWall extends Transparent{
    use PlaceholderTrait;

    public function __construct(int $id, string $name, int $meta = 0)
    {
        parent::__construct($id, $meta, $name);
    }

    public function getToolType() : int{
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

    public function getHardness() : float{
        return 1.5;
    }

    public function getBlastResistance(): float
    {
        return 6;
    }

    // Unfortunately walls dont connect in PocketMine (I also checked Nukkit, its the same thing)
}
