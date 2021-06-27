<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Block;
use pocketmine\block\Stair;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\TieredTool;
use pocketmine\math\Vector3;
use pocketmine\Player;

class PrisStairs extends Transparent {
    use PlaceholderTrait;

    public function __construct(int $id, string $name, int $meta = 0)
    {
        parent::__construct($id, $meta, $name);
    }

    public function getBlastResistance(): float
    {
        return 6;
    }

    public function getHardness(): float
    {
        return 1.5;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool
    {
  		$faces = [
  			0 => 0,
  			1 => 2,
  			2 => 1,
  			3 => 3
  		];
  		$this->meta = $player !== null ? $faces[$player->getDirection()] & 0x03 : 0;
  		if(($clickVector->y > 0.5 and $face !== Vector3::SIDE_UP) or $face === Vector3::SIDE_DOWN){
  			$this->meta |= 0x04; //Upside-down stairs
  		}
  		$this->getLevelNonNull()->setBlock($blockReplace, $this, true, true);

  		return true;
  	}

    public function getDrops(Item $item): array // Give a new item because the old items wouldn't stack (Due to damage?)
    {
        return [
            ItemFactory::get(255 - $this->getId())
        ];
    }
}
