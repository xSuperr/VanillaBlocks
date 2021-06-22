<?php

namespace xSuper\VanillaBlocks\items;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\item\Item;
use xSuper\VanillaBlocks\blocks\CampfireBlock;

class Campfire extends Item{

	public function __construct($meta = 0){
		parent::__construct(720, $meta, "Campfire");
	}

	public function getBlock() : Block{
		return new CampfireBlock();
	}

	public function getMaxStackSize() : int{
		return 1;
	}
}