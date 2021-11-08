<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use pocketmine\block\BlockToolType;

trait MaterialStoneTrait
{
	public function getHardness(): float
	{
		return 1.5;
	}

	public function getBlastResistance(): float
	{
		return 6;
	}

	public function getToolType(): int
	{
		return BlockToolType::TYPE_PICKAXE;
	}
}