<?php

namespace xSuper\VanillaBlocks\blocks\items;

use pocketmine\block\Block;
use pocketmine\item\Item;
use xSuper\VanillaBlocks\blocks\CampfireBlock;
use xSuper\VanillaBlocks\blocks\VanillaBlockIds;

class CampfireItem extends Item
{

    public function __construct($meta = 0){
        parent::__construct(VanillaBlockIds::CAMPFIRE_ITEM, $meta, "Campfire");
    }

    public function getBlock() : Block{
        return new CampfireBlock();
    }

    public function getMaxStackSize() : int{
        return 1;
    }
}
