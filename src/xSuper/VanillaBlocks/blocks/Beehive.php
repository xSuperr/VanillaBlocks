<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;



/**
 * Block minecraft:beehive
 */
class Beehive extends BeeNest
{
	protected $id = VanillaBlockIds::BEEHIVE;
	protected $meta = 0;
	protected $name = "Beehive";
	
	function __construct($id, $name)
	{
		parent::__construct($id, $name);
	}

	public function getBlastResistance(): float
    {
        return 0.6;
    }

    public function getHardness(): float
    {
        return 0.6;
    }
}