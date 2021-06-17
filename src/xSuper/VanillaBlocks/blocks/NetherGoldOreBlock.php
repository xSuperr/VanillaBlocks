<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\BlockToolType;
use pocketmine\block\Solid;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\TieredTool;

class NetherGoldOreBlock extends Solid {
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::NETHER_GOLD_ORE, $meta, "Nether Gold Ore");
    }

    public function getBlastResistance(): float
    {
        return 3;
    }

    public function getHardness(): float
    {
        return 3;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }

    public function getDrops(Item $item): array
    {
        return [
            ItemFactory::get(Item::GOLD_NUGGET, 0, rand(2, 6))
        ];
    }
}



