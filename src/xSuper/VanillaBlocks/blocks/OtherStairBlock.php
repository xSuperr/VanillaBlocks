<?php

namespace xSuper\VanillaBlocks\blocks;

class OtherStairBlock extends StoneStairBlock
{
	public function __construct(int $id, string $name, int $meta = 0)
	{
		parent::__construct($id, $name, $meta);
	}
	
	public function getVariantBitmask(): int {
		return 0;
	}
	public function getHardness(): float {
		return 2;
	}
}
