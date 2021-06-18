<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\block\Solid;
use pocketmine\entity\Entity;
use pocketmine\entity\object\ItemEntity;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Tile;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;
use xSuper\VanillaBlocks\blocks\tiles\CampfireTile;

class CampfireBlock extends Solid
{
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::CAMPFIRE, $meta, "Campfire");
    }

    public function getBlastResistance(): float
    {
        return 2;
    }

    public function getHardness(): float
    {
        return 2;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_AXE;
    }

    public function getLightLevel(): int
    {
        return 15;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool
    {
        $below = $this->getSide(Vector3::SIDE_DOWN);

        if ($below->getId() === Item::AIR || $below->isTransparent()) return false;

        $damage = 0;
        if($player !== null) {
            $damage = $player->getDirection();
        }

        $this->setDamage($damage);
        $nbt = CampfireTile::createNBT($this);
        $nbt->setInt('ItemTime1', 0);
        $nbt->setInt('ItemTime2', 0);
        $nbt->setInt('ItemTime3', 0);
        $nbt->setInt('ItemTime4', 0);

        $this->getLevel()->setBlock($blockReplace, new Placeholder($this, Tile::createTile("Campfire", $this->getLevel(), $nbt)), true, true);
        return true;
    }

    public function onNearbyBlockChange(): void
    {
        $below = $this->getSide(Vector3::SIDE_DOWN);
        if ($below->getId() === Item::AIR || $below->isTransparent()) {
            $this->getLevelNonNull()->useBreakOn($this);
        }
    }

    public function getDrops(Item $item): array // Give a new item because the old items wouldn't stack (Due to damage?)
    {
        $tile = $this->getLevel()->getTile($this);
        if ($tile instanceof CampfireTile) {
            $drops = $tile->getItems();
            $drops[] = ItemFactory::get(255 - $this->getId());
        } else $drops = [];

        return $drops;
    }

    public function onActivate(Item $item, Player $player = null): bool
    {
        if ($player !== null) {
            $tile = $this->getLevel()->getTile($this);
            if ($tile instanceof CampfireTile) {
                if ($tile->canAddItem($player->getInventory()->getItemInHand())) {
                    $tile->addItem($player->getInventory()->getItemInHand()->setCount(1));
                    $item = $player->getInventory()->getItemInHand()->setCount($player->getInventory()->getItemInHand()->getCount() - 1);
                    $player->getInventory()->setItemInHand($item);
                }
            }
        }
        return true;
    }

    public function onEntityCollide(Entity $entity): void
    {
        $fire = true;
        if ($entity instanceof Player) {
            if ($entity->isCreative()) $fire = false;
            if ($entity->isOnFire()) $fire = false;
        }

        if ($entity instanceof ItemEntity) $fire = false;

        if ($fire) $entity->setOnFire(8);
        parent::onEntityCollide($entity);
    }

    public function hasEntityCollision(): bool
    {
        return true;
    }
}


