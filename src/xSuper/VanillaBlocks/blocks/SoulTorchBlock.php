<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Block;
use pocketmine\block\Flowable;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;

class SoulTorchBlock extends Flowable
{
    use PlaceholderTrait;

    public function __construct(int $meta = 0)
    {
        parent::__construct(VanillaBlockIds::SOUL_TORCH, $meta, "Soul Torch");
    }

    public function getLightLevel() : int{
        return 10;
    }

    public function onNearbyBlockChange() : void{
        $below = $this->getSide(Vector3::SIDE_DOWN);
        $meta = $this->getDamage();
        static $faces = [
            0 => Vector3::SIDE_DOWN,
            1 => Vector3::SIDE_WEST,
            2 => Vector3::SIDE_EAST,
            3 => Vector3::SIDE_NORTH,
            4 => Vector3::SIDE_SOUTH,
            5 => Vector3::SIDE_DOWN
        ];
        $face = $faces[$meta] ?? Vector3::SIDE_DOWN;

        if($this->getSide($face)->isTransparent() and !($face === Vector3::SIDE_DOWN and ($below->getId() === self::FENCE or $below->getId() === self::COBBLESTONE_WALL))){
            $this->getLevelNonNull()->useBreakOn($this);
        }
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        $below = $this->getSide(Vector3::SIDE_DOWN);

        if(!$blockClicked->isTransparent() and $face !== Vector3::SIDE_DOWN){
            $faces = [
                Vector3::SIDE_UP => 5,
                Vector3::SIDE_NORTH => 4,
                Vector3::SIDE_SOUTH => 3,
                Vector3::SIDE_WEST => 2,
                Vector3::SIDE_EAST => 1
            ];
            $this->meta = $faces[$face];
            $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true, true);

            return true;
        }elseif(!$below->isTransparent() or $below->getId() === self::FENCE or $below->getId() === self::COBBLESTONE_WALL){
            $this->meta = 0;
            $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true, true);

            return true;
        }

        return false;
    }

    public function getVariantBitmask() : int{
        return 0;
    }
}
