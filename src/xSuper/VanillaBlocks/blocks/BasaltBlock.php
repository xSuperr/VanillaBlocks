<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\block\Solid;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\TieredTool;
use pocketmine\math\Vector3;
use pocketmine\Player;

class BasaltBlock extends Solid {
    use PlaceholderTrait;

    public function __construct(int $id, string $name, int $meta = 0)
    {
        parent::__construct($id, $meta, $name);
    }

    public function getBlastResistance(): float
    {
        return 4.2;
    }

    public function getHardness(): float
    {
        return 1.25;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool
    {
        $damage = 0;
        if ($face === Vector3::SIDE_EAST || $face === Vector3::SIDE_WEST) $damage = 1;
        else if ($face === Vector3::SIDE_NORTH || $face === Vector3::SIDE_SOUTH) $damage = 2;

        $this->meta = $damage;
        $this->getLevel()->setBlock($blockReplace, new Placeholder($this), true, true);
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
}


