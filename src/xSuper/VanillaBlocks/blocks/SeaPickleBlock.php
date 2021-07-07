<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use JavierLeon9966\ExtendedBlocks\item\ItemFactory;
use pocketmine\block\Block;
use pocketmine\block\Transparent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;

class SeaPickleBlock extends Transparent {
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::SEA_PICKLE, $meta, "Sea Pickle");
    }

    public function getBlastResistance(): float
    {
        return 0;
    }

    public function getHardness(): float
    {
        return 0;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool
    {
        if (!$this->getSide(Vector3::SIDE_DOWN)->isTransparent()) {
            $place = true;
            if ($blockClicked instanceof Placeholder) {
                if ($blockClicked->getBlock() instanceof SeaPickleBlock) {
                    $place = false;
                }
            }
            if ($place) return $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true);
        }
        return false;
    }

    public function onActivate(Item $item, Player $player = null): bool
    {
        if ($this->getAmount() >= 4) return true;
        else {
            $this->meta = $this->meta + 1;
            $this->getLevel()->setBlock($this, new Placeholder($this), true, true);
            if ($player !== null && !$player->isCreative()) {
                $item->setCount($item->getCount() - 1);
                $player->getInventory()->setItemInHand($item);
            }
            return false;
        }
    }

    public function getAmount(): int
    {
        if ($this->meta === 0) return 1;
        else if ($this->meta === 1) return 2;
        else if ($this->meta === 2) return 3;
        else if ($this->meta === 3) return 4;
        return 1;
    }

    public function getDrops(Item $item): array
    {
        return [
            ItemFactory::get(255 - $this->getId(), 0, $this->getAmount())
        ];
    }

    public function getPickedItem(): Item
    {
        return ItemFactory::get(255 - $this->getId());
    }
}




