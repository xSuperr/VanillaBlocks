<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use pocketmine\block\BlockToolType;
use pocketmine\math\Vector3;

/**
 * Block minecraft:chain
 */
class Chain extends StrippedLogBlock
{
	function __construct()
	{
		parent::__construct(VanillaBlockIds::CHAIN, "Chain");
	}
	
	public function getBlastResistance(): float {
        return 6;
    }

    public function getHardness(): float {
        return 5;
    }

    public function getToolType(): int {
        return BlockToolType::TYPE_PICKAXE;
    }
}