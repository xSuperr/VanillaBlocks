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

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        $damage = 0;
        if($player !== null) {
            $faces = [1, 2, 1, 2];
            $damage = $faces[$player->getDirection()];
            if ($player->getPitch() > 45) {
                $damage = 0;
            } else if ($player->getPitch() < -45) {
                $damage = 5;
            }
        }

        $this->setDamage($damage);
        return $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true);
    }

    public function getDrops(Item $item): array // Give a new item because the old items wouldn't stack (Due to damage?)
    {
        return [
            ItemFactory::get(255 - $this->getId())
        ];
    }
}


