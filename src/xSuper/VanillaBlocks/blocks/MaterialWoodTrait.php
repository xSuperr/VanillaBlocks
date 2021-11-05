<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use pocketmine\block\BlockToolType;

trait MaterialWoodTrait
{
	public function getHardness(): float
	{
		return 2;
	}

	public function getToolType(): int
	{
		return BlockToolType::TYPE_AXE;
	}
}