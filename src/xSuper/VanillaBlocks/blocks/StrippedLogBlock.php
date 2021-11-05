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

class StrippedLogBlock extends Solid {
    use PlaceholderTrait;

    public function __construct(int $id, string $name, int $meta = 0)
    {
        parent::__construct($id, $meta, $name);
    }

    public function getBlastResistance(): float {
        return 2;
    }

    public function getHardness(): float {
        return 2;
    }

    public function getToolType(): int {
        return BlockToolType::TYPE_AXE;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        switch ($face) {
            case Vector3::SIDE_NORTH:
            case Vector3::SIDE_SOUTH:
                $this->meta = 2;
            case Vector3::SIDE_EAST:
            case Vector3::SIDE_WEST:
                $this->meta = 1;
                break;
            default:
                $this->meta = 0;
                break;
        }
        return $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true);
    }

    public function getDrops(Item $item): array
    {
        return [
            ItemFactory::get(255 - $this->getId())
        ];
    }

    public function getPickedItem(): Item
    {
        return ItemFactory::get(255 - $this->getId());
    }
}


