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
        if(abs($player->getPosition()->getX() - $this->asPosition()->getX()) < 2 && abs($player->getPosition()->getZ() - $this->asPosition()->getZ()) < 2){
            $y = $player->asPosition()->getY()+1;

            if($y - $this->asPosition()->getY() > 2){
                $this->facing = 0 << 1 | 1;
            }elseif($this->asPosition()->getY() - $y > 0){
                $this->facing = 0 << 1;
            }else{
                $this->facing = $this->getHorizontalFacing($player) ^ 1;
            }
        }else{
            $this->facing = $this->getHorizontalFacing($player) ^ 1;
        }

        $this->meta = $this->facing | $this->meta << 2;

        $this->getLevel()->setBlock($blockReplace, new Placeholder($this, Tile::createTile("Barrel", $this->getLevel(), BarrelTile::createNBT($this))), true);
        return true;
    }

    public function getHorizontalFacing(Player $player) : int{
        $angle = fmod($player->asLocation()->yaw, 360);
        if($angle < 0){
            $angle += 360.0;
        }

        if((0 <= $angle and $angle < 45) or (315 <= $angle and $angle < 360)){
            return 1 << 1 | 1;
        }
        if(45 <= $angle and $angle < 135){
            return 2 << 1;
        }
        if(135 <= $angle and $angle < 225){
            return 1 << 1;
        }

        return 2 << 1 | 1;
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

