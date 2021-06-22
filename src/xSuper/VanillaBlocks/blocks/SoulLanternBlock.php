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

class SoulLanternBlock extends Solid {
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::SOUL_LANTERN, $meta, "Soul Lantern");
    }

    public function getBlastResistance(): float
    {
        return 3.5;
    }

    public function getHardness(): float
    {
        return 3.5;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }

    public function getLightLevel(): int
    {
        return 10;
    }

    public function onNearbyBlockChange(): void
    {
        $below = $this->getSide(Vector3::SIDE_DOWN);
        $above = $this->getSide(Vector3::SIDE_UP);
        $meta = $this->getDamage();
        if ($meta === 0) {
            if ($below->getId() === Item::AIR || $below->isTransparent()) {
                $this->getLevelNonNull()->useBreakOn($this);
            }
        } else if ($meta === 1) {
            if ($above->getId() === Item::AIR || $above->isTransparent()) {
                $this->getLevelNonNull()->useBreakOn($this);
            }
        } else return;
    }

    // This whole thing confused me
    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool
    {
        $above = $this->getSide(Vector3::SIDE_UP);

        if (!$blockClicked->isTransparent() && $face !== Vector3::SIDE_DOWN) {
            if ($face !== 1) return false;
            $this->setDamage(0);
            $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true, true);

            return true;
        } else if ($face !== Vector3::SIDE_UP) {
            if ($above->getId() === Item::AIR) return false;
            $this->setDamage(1);
            $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true, true);

            return true;
        }

        return false;
    }

    public function getDrops(Item $item): array // Give a new item because the old items wouldn't stack (Due to damage?)
    {
        return [
            ItemFactory::get(255 - $this->getId())
        ];
    }
}



