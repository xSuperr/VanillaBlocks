<?php

namespace xSuper\VanillaBlocks;

use JavierLeon9966\ExtendedBlocks\block\BlockFactory;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\tile\Tile;
use xSuper\VanillaBlocks\blocks\AncientDebrisBlock;
use xSuper\VanillaBlocks\blocks\BarrelBlock;
use xSuper\VanillaBlocks\blocks\BarrierBlock;
use xSuper\VanillaBlocks\blocks\BasaltBlock;
use xSuper\VanillaBlocks\blocks\BlackstoneBlock;
use xSuper\VanillaBlocks\blocks\BlackstoneWall;
use xSuper\VanillaBlocks\blocks\CampfireBlock;
use xSuper\VanillaBlocks\blocks\ChiseledPolishedBlackstoneBlock;
use xSuper\VanillaBlocks\blocks\CrackedPolishedBlackstoneBricksBlock;
use xSuper\VanillaBlocks\blocks\LanternBlock;
use xSuper\VanillaBlocks\blocks\SoulLanternBlock;
use xSuper\VanillaBlocks\blocks\NetherGoldOreBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneBricksBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneWallBlock;
use xSuper\VanillaBlocks\blocks\StrippedLogBlock;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;
use xSuper\VanillaBlocks\blocks\tiles\CampfireTile;
use xSuper\VanillaBlocks\blocks\VanillaBlockIds;
use xSuper\VanillaBlocks\items\ItemManager;

class VanillaBlocks extends PluginBase
{
    /** @var VanillaBlocks */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;

		ItemManager::init();

        self::registerBlock(new AncientDebrisBlock());
        self::registerBlock(new BarrelBlock());
        self::registerBlock(new BarrierBlock());
        self::registerBlock(new BasaltBlock());
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_OAK, "Stripped Oak Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_SPRUCE, "Stripped Spruce Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_BIRCH, "Stripped Birch Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_JUNGLE, "Stripped Jungle Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_ACACIA, "Stripped Acacia Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_DARK_OAK, "Stripped Dark Oak Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_CRIMSON, "Stripped Crimson Stem"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_WARPED, "Stripped Warped Log"));
        self::registerBlock(new NetherGoldOreBlock());
        self::registerBlock(new LanternBlock());
        self::registerBlock(new SoulLanternBlock());
        self::registerBlock(new CampfireBlock(), true, false);
        self::registerBlock(new BlackstoneBlock());
        self::registerBlock(new PolishedBlackstoneBlock());
        self::registerBlock(new ChiseledPolishedBlackstoneBlock());
        self::registerBlock(new PolishedBlackstoneBricksBlock());
        self::registerBlock(new CrackedPolishedBlackstoneBricksBlock());
        self::registerBlock(new BlackstoneWall(VanillaBlockIds::BLACKSTONE_WALL, "Blackstone Wall"));
        self::registerBlock(new BlackstoneWall(VanillaBlockIds::POLISHED_BLACKSTONE_BRICK_WALL, "Polished Blackstone Brick Wall"));
        self::registerBlock(new PolishedBlackstoneWallBlock());
        Tile::registerTile(BarrelTile::class, ["Barrel"]);
        Tile::registerTile(CampfireTile::class, ["Campfire"]);
    }

    public static function registerBlock(Block $block, $override = true, $creative = true): void
    {
        BlockFactory::registerBlock($block, $override);
        if ($creative) Item::addCreativeItem(ItemFactory::get($block->getItemId()));
    }

    public static function getInstance(): VanillaBlocks
    {
        return self::$instance;
    }
}
