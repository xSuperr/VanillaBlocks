<?php

namespace xSuper\VanillaBlocks;

use JavierLeon9966\ExtendedBlocks\block\BlockFactory;
use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Tile;
use xSuper\VanillaBlocks\blocks\AncientDebrisBlock;
use xSuper\VanillaBlocks\blocks\BarrelBlock;
use xSuper\VanillaBlocks\blocks\BarrierBlock;
use xSuper\VanillaBlocks\blocks\BasaltBlock;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;

class VanillaBlocks extends PluginBase implements Listener
{
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        self::registerBlock(new AncientDebrisBlock());
        self::registerBlock(new BarrelBlock());
        self::registerBlock(new BarrierBlock());
        self::registerBlock(new BasaltBlock());
        Tile::registerTile(BarrelTile::class, ["Barrel"]);
    }

    public static function registerBlock(Block $block, $override = true, $creative = true): void
    {
        BlockFactory::registerBlock($block, $override);
        if ($creative) Item::addCreativeItem(ItemFactory::get($block->getItemId()));
    }
}
