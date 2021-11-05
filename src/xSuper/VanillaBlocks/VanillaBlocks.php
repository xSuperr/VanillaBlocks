<?php

namespace xSuper\VanillaBlocks;

use JavierLeon9966\ExtendedBlocks\block\BlockFactory;
use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\item\ItemFactory;
use pocketmine\level\Position;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\tile\Tile;
use ReflectionException;
use xSuper\VanillaBlocks\blocks\AncientDebrisBlock;
use xSuper\VanillaBlocks\blocks\AmethystBlock;
use xSuper\VanillaBlocks\blocks\BarrelBlock;
use xSuper\VanillaBlocks\blocks\BarrierBlock;
use xSuper\VanillaBlocks\blocks\BasaltBlock;
use xSuper\VanillaBlocks\blocks\BlackstoneBlock;
use xSuper\VanillaBlocks\blocks\BlackstoneWall;
use xSuper\VanillaBlocks\blocks\CampfireBlock;
use xSuper\VanillaBlocks\blocks\ChiseledPolishedBlackstoneBlock;
use xSuper\VanillaBlocks\blocks\Coral;
use xSuper\VanillaBlocks\blocks\CoralBlock;
use xSuper\VanillaBlocks\blocks\CoralFanBlock;
use xSuper\VanillaBlocks\blocks\CrackedPolishedBlackstoneBricksBlock;
use xSuper\VanillaBlocks\blocks\items\CampfireItem;
use xSuper\VanillaBlocks\blocks\items\RecordItem;
use xSuper\VanillaBlocks\blocks\items\SoulCampfireItem;
use xSuper\VanillaBlocks\blocks\JukeboxBlock;
use xSuper\VanillaBlocks\blocks\LanternBlock;
use xSuper\VanillaBlocks\blocks\NetherGoldOreBlock;
use xSuper\VanillaBlocks\blocks\NetherPlanksBlock;
use xSuper\VanillaBlocks\blocks\overrides\LogBlock;
use xSuper\VanillaBlocks\blocks\overrides\LogBlock2;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneBricksBlock;
use xSuper\VanillaBlocks\blocks\PolishedBlackstoneWallBlock;
use xSuper\VanillaBlocks\blocks\ScaffoldingBlock;
use xSuper\VanillaBlocks\blocks\SeaPickleBlock;
use xSuper\VanillaBlocks\blocks\SoulCampfireBlock;
use xSuper\VanillaBlocks\blocks\SoulLanternBlock;
use xSuper\VanillaBlocks\blocks\SoulSoilBlock;
use xSuper\VanillaBlocks\blocks\SoulTorchBlock;
use xSuper\VanillaBlocks\blocks\StrippedLogBlock;
use xSuper\VanillaBlocks\blocks\tiles\JukeboxTile;
use xSuper\VanillaBlocks\blocks\WoodenStairBlock;
use xSuper\VanillaBlocks\blocks\StoneStairBlock;
use xSuper\VanillaBlocks\blocks\OtherStairBlock;
use xSuper\VanillaBlocks\blocks\TrapdoorBlock;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;
use xSuper\VanillaBlocks\blocks\tiles\CampfireTile;
use xSuper\VanillaBlocks\blocks\VanillaBlockIds;

class VanillaBlocks extends PluginBase implements Listener {
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

    /**
     * @throws ReflectionException
     */
    public static function Init(): void
    {
        // self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Dead Brain Coral", 9));
        // self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Dead Bubble Coral", 10));
        // self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Dead Fire Coral", 11));
        // self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Dead Horn Coral", 12));
        // self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Dead Tube Coral", 8));
        // These are not in PocketMine yet?
        foreach (self::getRecords() as $record) self::registerItem($record);
        self::registerBlock(new AncientDebrisBlock());
        self::registerBlock(new BarrelBlock());
        self::registerBlock(new BarrierBlock());
        self::registerBlock(new BasaltBlock(VanillaBlockIds::BASALT, "Basalt"));
        self::registerBlock(new BasaltBlock(VanillaBlockIds::POLISHED_BASALT, "Polished Basalt"));
        self::registerBlock(new BlackstoneBlock());
        self::registerBlock(new BlackstoneWall(VanillaBlockIds::BLACKSTONE_WALL, "Blackstone Wall"));
        self::registerBlock(new BlackstoneWall(VanillaBlockIds::POLISHED_BLACKSTONE_BRICK_WALL, "Polished Blackstone Brick Wall"));
        self::registerBlock(new CampfireBlock(), true, false);
        self::registerBlock(new ChiseledPolishedBlackstoneBlock());
        self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Brain Coral", 1));
        self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Bubble Coral", 2));
        self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Fire Coral", 3));
        self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Horn Coral", 4));
        self::registerBlock(new Coral(VanillaBlockIds::CORAL, "Tube Coral"));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Brain Coral Block", 1));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Bubble Coral Block", 2));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Dead Brain Coral Block", 9));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Dead Bubble Coral Block", 10));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Dead Fire Coral Block", 11));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Dead Horn Coral Block", 12));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Dead Tube Coral Block", 8));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Fire Coral Block", 3));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Horn Coral Block", 4));
        self::registerBlock(new CoralBlock(VanillaBlockIds::CORAL_BLOCK, "Tube Coral Block"));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Brain Coral Fan", 1));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Bubble Coral Fan", 2));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Fire Coral Fan", 3));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Horn Coral Fan", 4));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Tube Coral Fan"));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Coral Wall"), true, false);
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Coral Wall"), true, false);
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Coral Wall"), true, false);
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Brain Coral Fan", 1));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Bubble Coral Fan", 2));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Fire Coral Fan", 3));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Horn Coral Fan", 4));
        self::registerBlock(new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Tube Coral Fan"));
        self::registerBlock(new CrackedPolishedBlackstoneBricksBlock());
        self::registerBlock(new JukeboxBlock());
        self::registerBlock(new LanternBlock());
        self::registerBlock(new LogBlock(), true, false);
        self::registerBlock(new LogBlock2(), true, false);
        self::registerBlock(new NetherGoldOreBlock());
        self::registerBlock(new NetherPlanksBlock(VanillaBlockIds::CRIMSON_PLANKS, "Crimson Planks"));
        self::registerBlock(new NetherPlanksBlock(VanillaBlockIds::WARPED_PLANKS, "Warped Planks"));
        self::registerBlock(new OtherStairBlock(VanillaBlockIds::MOSSY_COBBLESTONE_STAIR, "Mossy Cobblestone Stairs"));
        self::registerBlock(new OtherStairBlock(VanillaBlockIds::POLISHED_BLACKSTONE_STAIR, "Polished BlackStone Stairs"));
        self::registerBlock(new OtherStairBlock(VanillaBlockIds::RED_NETHERBRICK_STAIR, "Red NetherBrick Stairs"));
        self::registerBlock(new OtherStairBlock(VanillaBlockIds::SMOOTH_QUARTZ_STAIR, "Smooth Quartz Stairs"));
        self::registerBlock(new OtherStairBlock(VanillaBlockIds::SMOOTH_RED_SANDSTONE_STAIR, "Smooth Red Sandstone Stairs"));
        self::registerBlock(new OtherStairBlock(VanillaBlockIds::SMOOTH_SANDSTONE_STAIR, "Smooth SandStone Stairs"));
        self::registerBlock(new PolishedBlackstoneBlock());
        self::registerBlock(new PolishedBlackstoneBricksBlock());
        self::registerBlock(new PolishedBlackstoneWallBlock());
        self::registerBlock(new ScaffoldingBlock());
        self::registerBlock(new SeaPickleBlock());
        self::registerBlock(new SoulCampfireBlock(), true, false);
        self::registerBlock(new SoulLanternBlock());
        self::registerBlock(new SoulSoilBlock());
        self::registerBlock(new SoulTorchBlock());
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::ANDESITE_STAIR, "Andesite Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::DIORITE_STAIR, "Diorite Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::GRANITE_STAIR, "Granite Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::MOSSY_STONE_BRICK_STAIR, "Mossy Stone Brick Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::POLISHED_ANDESITE_STAIR, "Polished Andesite Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::POLISHED_DIORITE_STAIR, "Polished Diorite Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::POLISHED_GRANITE_STAIR, "Polished Granite Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::PRISMARINE_BRICK_STAIR, "Prismarine Brick Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::PRISMARINE_STAIR, "Prismarine Stairs"));
        self::registerBlock(new StoneStairBlock(VanillaBlockIds::STONE_STAIR, "Stone Stairs"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_ACACIA, "Stripped Acacia Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_BIRCH, "Stripped Birch Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_CRIMSON, "Stripped Crimson Stem"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_DARK_OAK, "Stripped Dark Oak Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_JUNGLE, "Stripped Jungle Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_OAK, "Stripped Oak Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_SPRUCE, "Stripped Spruce Log"));
        self::registerBlock(new StrippedLogBlock(VanillaBlockIds::STRIPPED_WARPED, "Stripped Warped Log"));
        self::registerBlock(new TrapdoorBlock(VanillaBlockIds::ACACIA_TRAPDOOR, "Acacia Trapdoor"));
        self::registerBlock(new TrapdoorBlock(VanillaBlockIds::BIRCH_TRAPDOOR, "Birch Trapdoor"));
        self::registerBlock(new TrapdoorBlock(VanillaBlockIds::CRIMSON_TRAPDOOR, "Crimson Trapdoor"));
        self::registerBlock(new TrapdoorBlock(VanillaBlockIds::DARK_OAK_TRAPDOOR, "Dark Oak Trapdoor"));
        self::registerBlock(new TrapdoorBlock(VanillaBlockIds::JUNGLE_TRAPDOOR, "Jungle Trapdoor"));
        self::registerBlock(new TrapdoorBlock(VanillaBlockIds::SPRUCE_TRAPDOOR, "Spruce Trapdoor"));
        self::registerBlock(new TrapdoorBlock(VanillaBlockIds::WARPED_TRAPDOOR, "Warped Trapdoor"));
        self::registerBlock(new WoodenStairBlock(VanillaBlockIds::CRIMSON_STAIR, "Crimson Stairs"));
        self::registerBlock(new WoodenStairBlock(VanillaBlockIds::WARPED_STAIR, "Warped Stairs"));
        self::registerItem(new CampfireItem());
        self::registerItem(new SoulCampfireItem());
        Tile::registerTile(BarrelTile::class, ["Barrel"]);
        Tile::registerTile(CampfireTile::class, ["Campfire"]);
        Tile::registerTile(JukeboxTile::class, ["Jukebox"]);
    }

    public static function registerBlock(Block $block, $override = true, $creative = true): void
    {
        BlockFactory::registerBlock($block, $override);
        if ($creative) {
            if ($block->getId() > 255) $id = 255 - $block->getId();
            else $id = $block->getId();
            $item = new ItemBlock($block->getId(), $block->getDamage(), $id);
            ItemFactory::registerItem($item, $override);
            Item::addCreativeItem($item);
        }
    }

    public static function registerItem(Item $item, $override = true): void
    {
        ItemFactory::registerItem($item, $override);
        Item::addCreativeItem($item);
    }

    public static function getRecords(): array
    {
        return [
            new RecordItem(500, "C418 - 13", LevelSoundEventPacket::SOUND_RECORD_13),
            new RecordItem(501, "C418 - cat", LevelSoundEventPacket::SOUND_RECORD_CAT),
            new RecordItem(502, "C418 - blocks", LevelSoundEventPacket::SOUND_RECORD_BLOCKS),
            new RecordItem(503, "C418 - chirp", LevelSoundEventPacket::SOUND_RECORD_CHIRP),
            new RecordItem(504, "C418 - far", LevelSoundEventPacket::SOUND_RECORD_FAR),
            new RecordItem(505, "C418 - mall", LevelSoundEventPacket::SOUND_RECORD_MALL),
            new RecordItem(506, "C418 - mellohi", LevelSoundEventPacket::SOUND_RECORD_MELLOHI),
            new RecordItem(507, "C418 - stal", LevelSoundEventPacket::SOUND_RECORD_STAL),
            new RecordItem(508, "C418 - strad", LevelSoundEventPacket::SOUND_RECORD_STRAD),
            new RecordItem(509, "C418 - ward", LevelSoundEventPacket::SOUND_RECORD_WARD),
            new RecordItem(510, "C418 - 11", LevelSoundEventPacket::SOUND_RECORD_11),
            new RecordItem(511, "C418 - wait", LevelSoundEventPacket::SOUND_RECORD_WAIT),
            new RecordItem(759, "Lena Raine - Pigstep", LevelSoundEventPacket::SOUND_RECORD_PIGSTEP)
            ];
    }

    public static function getInstance(): VanillaBlocks
    {
        return self::$instance;
    }

    public function onTeleport(EntityTeleportEvent $event): void // TODO: Test these fixes
    {
        if ($event->getEntity() instanceof Player) {
            $player = $event->getEntity();

            $player->setGenericFlag(Entity::DATA_FLAG_IN_SCAFFOLDING, false);
            $player->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING, false);
            $player->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING, false);
        }
    }

    public function onLevelChange(EntityLevelChangeEvent $event): void // TODO: Test these fixes (and if this is even needed)
    {
        if ($event->getEntity() instanceof Player) {
            $player = $event->getEntity();

            $player->setGenericFlag(Entity::DATA_FLAG_IN_SCAFFOLDING, false);
            $player->setGenericFlag(Entity::DATA_FLAG_FALL_THROUGH_SCAFFOLDING, false);
            $player->setGenericFlag(Entity::DATA_FLAG_OVER_SCAFFOLDING, false);
        }
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
                if ($from instanceof ScaffoldingBlock) {
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
