<?php

namespace xSuper\VanillaBlocks\blocks\items;

use pocketmine\block\Block;
use pocketmine\item\Item;
use xSuper\VanillaBlocks\blocks\SoulCampfireBlock;
use xSuper\VanillaBlocks\blocks\VanillaBlockIds;

class SoulCampfireItem extends Item
{

    public function __construct($meta = 0){
        parent::__construct(VanillaBlockIds::SOUL_CAMPFIRE_ITEM, $meta, "Soul Campfire");
    }

    public function getBlock() : Block{
        return new SoulCampfireBlock();
    }

    public function getMaxStackSize() : int{
        return 1;
    }
}

