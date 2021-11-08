<?php

namespace xSuper\VanillaBlocks\blocks;

use pocketmine\block\BlockToolType;
use pocketmine\item\TieredTool;

class StoneStairBlock extends Stair
{
	use MaterialStoneTrait;
	
	public function __construct(int $id, string $name, int $meta = 0)
	{
		parent::__construct($id, $name, $meta);
	}

	public function getToolHarvestLevel(): int {
		return TieredTool::TIER_WOODEN;
	}
}
