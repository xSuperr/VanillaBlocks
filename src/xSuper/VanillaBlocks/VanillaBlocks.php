<?php

namespace xSuper\VanillaBlocks;

use JavierLeon9966\ExtendedBlocks\block\BlockFactory;
use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\level\Position;
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
use xSuper\VanillaBlocks\blocks\items\CampfireItem;
use xSuper\VanillaBlocks\blocks\items\SoulCampfireItem;
use xSuper\VanillaBlocks\blocks\LanternBlock;
use xSuper\VanillaBlocks\blocks\NetherGoldOreBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneBricksBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneWallBlock;
use xSuper\VanillaBlocks\blocks\ScaffoldingBlock;
use xSuper\VanillaBlocks\blocks\SoulCampfireBlock;
use xSuper\VanillaBlocks\blocks\SoulLanternBlock;
use xSuper\VanillaBlocks\blocks\SoulSoilBlock;
use xSuper\VanillaBlocks\blocks\SoulTorchBlock;
use xSuper\VanillaBlocks\blocks\PrisStairs;
use xSuper\VanillaBlocks\blocks\StrippedLogBlock;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;
use xSuper\VanillaBlocks\blocks\tiles\CampfireTile;
use xSuper\VanillaBlocks\blocks\VanillaBlockIds;

class VanillaBlocks extends PluginBase implements Listener
{
    /** @var VanillaBlocks */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        VanillaBlocks::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function (): void{ // Add a delay on this because Item::initCreativeItems() has to be ran before blocks
            self::Init();
        }), 20);
    }

    public static function Init(): void
    {
        self::registerBlock(new PrisStairs(VanillaBlockIds::PRISMARINE_STAIRS, "Prismarine Stairs"));
        self::registerBlock(new PrisStairs(VanillaBlockIds::PRISMARINE_BRICK_STAIRS, "Prismarine Brick Stairs"));
        self::registerBlock(new PrisStairs(VanillaBlockIds::DARK_PRISMARINE_STAIRS, "Dark Prismarine Stairs"));
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
        self::registerBlock(new CampfireBlock(), true, false);
        self::registerBlock(new BlackstoneBlock());
        self::registerBlock(new PolishedBlackstoneBlock());
        self::registerBlock(new ChiseledPolishedBlackstoneBlock());
        self::registerBlock(new PolishedBlackstoneBricksBlock());
        self::registerBlock(new CrackedPolishedBlackstoneBricksBlock());
        self::registerBlock(new BlackstoneWall(VanillaBlockIds::BLACKSTONE_WALL, "Blackstone Wall"));
        self::registerBlock(new BlackstoneWall(VanillaBlockIds::POLISHED_BLACKSTONE_BRICK_WALL, "Polished Blackstone Brick Wall"));
        self::registerBlock(new PolishedBlackstoneWallBlock());
        self::registerBlock(new SoulCampfireBlock(), true, false);
        self::registerBlock(new SoulTorchBlock());
        self::registerBlock(new SoulLanternBlock());
        self::registerItem(new CampfireItem());
        self::registerItem(new SoulCampfireItem());
        self::registerBlock(new SoulSoilBlock());
        self::registerBlock(new ScaffoldingBlock());
        Tile::registerTile(BarrelTile::class, ["Barrel"]);
        Tile::registerTile(CampfireTile::class, ["Campfire"]);
    }

    public static function registerBlock(Block $block, $override = true, $creative = true): void
    {
        BlockFactory::registerBlock($block, $override);
        if ($creative) Item::addCreativeItem(ItemFactory::get($block->getItemId()));
    }

    public static function registerItem(Item $item, $override = true): void
    {
        ItemFactory::registerItem($item, $override);
        Item::addCreativeItem($item);
    }

    public static function getInstance(): VanillaBlocks
    {
        return self::$instance;
    }

    public function onPlayerMove(PlayerMoveEvent $event): void
    {
        $to = $event->getPlayer()->getLevel()->getBlock($event->getTo());
        $from = $event->getPlayer()->getLevel()->getBlock($event->getFrom());
        $under = $event->getPlayer()->getLevel()->getBlock(new Position($event->getTo()->x, $event->getTo()->y - 1, $event->getTo()->z, $event->getTo()->level));
        if ($to instanceof Placeholder) {
            $to = $to->getBlock();
            if ($to instanceof ScaffoldingBlock) {
                $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_IN_SCAFFOLDING);
                $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING);
                $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING);
            } else if ($from instanceof Placeholder) {
                $from = $from->getBlock();
                if (!$to instanceof ScaffoldingBlock && $from instanceof ScaffoldingBlock) {
                    $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_IN_SCAFFOLDING, false);
                    $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING, false);
                    $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING, false);
                }
            }
        } else if ($under instanceof Placeholder) {
           $under = $under->getBlock();
           $under2 = $event->getPlayer()->getLevel()->getBlock(new Position($event->getTo()->x, $event->getTo()->y - 2, $event->getTo()->z, $event->getTo()->level));
           if ($under instanceof ScaffoldingBlock) {
               if ($under2 instanceof Placeholder) {
                   $under2 = $under2->getBlock();
                   $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_IN_SCAFFOLDING, false);
                   if ($under2 instanceof ScaffoldingBlock) {
                       $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING);
                       $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING);
                   } else {
                       $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING, false);
                       $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING, false);
                   }
               } else {
                   $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_IN_SCAFFOLDING, false);
                   $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING, false);
                   $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING, false);
               }
           }
        } else {
            if ($from instanceof Placeholder) {
                $from = $from->getBlock();
                if ($from instanceof ScaffoldingBlock) {
                    $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_IN_SCAFFOLDING, false);
                    $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING, false);
                    $event->getPlayer()->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING, false);
                }
            }
        }
    }
}
