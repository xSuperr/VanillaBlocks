<?php

namespace xSuper\VanillaBlocks\items;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

class ItemManager {
	public static function init(){
		ItemFactory::registerItem(new Campfire(), true);
	}
}