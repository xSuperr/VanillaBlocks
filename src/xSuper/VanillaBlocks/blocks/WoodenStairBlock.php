<?php

namespace xSuper\VanillaBlocks\blocks;

class WoodenStairBlock extends Stair
{
	use MaterialWoodTrait;

	public function __construct(int $id, string $name, int $meta = 0)
	{
		parent::__construct($id, $name, $meta);
	}

	public function getVariantBitmask(): int {
		return 0;
	}

	public function getBlastResistance(): float {
		return 3;
	}
	
	public function getFlameEncouragement(): int {
		return 5;
	}

	public function getFlammability(): int {
		return 20;
	}
}
