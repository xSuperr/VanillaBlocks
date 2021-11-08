<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Transparent;
use pocketmine\item\TieredTool;

class BlackstoneWall extends Transparent{
    use PlaceholderTrait, MaterialStoneTrait;

    public function __construct(int $id, string $name, int $meta = 0)
    {
        parent::__construct($id, $meta, $name);
    }

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

    // Unfortunately walls dont connect in PocketMine (I also checked Nukkit, its the same thing)
}
