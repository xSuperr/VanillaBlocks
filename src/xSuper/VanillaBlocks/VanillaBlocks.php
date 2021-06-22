<?php

namespace xSuper\VanillaBlocks;

use pocketmine\plugin\PluginBase;
use pocketmine\tile\Tile;
use xSuper\VanillaBlocks\blocks\BlockManager;
use xSuper\VanillaBlocks\items\ItemManager;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;
use xSuper\VanillaBlocks\blocks\tiles\CampfireTile;

class VanillaBlocks extends PluginBase
{
    /** @var VanillaBlocks */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;

		ItemManager::init();
		BlockManager::init();

        Tile::registerTile(BarrelTile::class, ["Barrel"]);
        Tile::registerTile(CampfireTile::class, ["Campfire"]);
    }

    public static function getInstance(): VanillaBlocks
    {
        return self::$instance;
    }
}
