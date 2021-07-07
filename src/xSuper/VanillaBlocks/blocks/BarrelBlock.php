<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\block\Solid;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Tile;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;

class BarrelBlock extends Solid
{
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::BARREL, $meta, "Barrel");
    }

    public function getBlastResistance(): float
    {
        return 2.5;
    }

    public function getHardness(): float
    {
        return 2.5;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_AXE;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool
    {
        $damage = 0;
        if ($face === Vector3::SIDE_UP) $damage = 1;
        else if ($face === Vector3::SIDE_EAST) $damage = 5;
        else if ($face === Vector3::SIDE_WEST) $damage = 4;
        else if ($face === Vector3::SIDE_SOUTH) $damage = 3;
        else if ($face === Vector3::SIDE_NORTH) $damage = 2;

        $this->meta = $damage;
        $this->getLevel()->setBlock($blockReplace, new Placeholder($this, Tile::createTile("Barrel", $this->getLevel(), BarrelTile::createNBT($this))), true);
        return true;
    }

    public function getDrops(Item $item): array // Give a new item because the old items wouldn't stack (Due to damage?)
    {
        return [
            ItemFactory::get(255 - $this->getId())
        ];
    }

    public function getPickedItem(): Item
    {
        return ItemFactory::get(255 - $this->getId());
    }

    public function onActivate(Item $item, Player $player = null): bool
    {
        if ($player !== null) {
            $tile = $this->getLevel()->getTile($this);
            if ($tile instanceof BarrelTile) $player->addWindow($tile->getInventory());
        }
        return true;
    }
}

