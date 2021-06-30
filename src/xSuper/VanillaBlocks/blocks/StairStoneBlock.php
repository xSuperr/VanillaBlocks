<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Transparent;
use pocketmine\block\BlockToolType;
use pocketmine\item\TieredTool;
use pocketmine\math\AxisAlignedBB;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\Player;

class StairStoneBlock extends Transparent {
    use PlaceholderTrait;
    
    //Todo
      //BlackStone
      //BlackStone Brick
    
    public function __construct(int $id, string $name, int $meta = 0) {
      parent::__construct($id, $meta, $name);
    }
    
    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
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
        $this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true, true);

        return true;
    }
    
    protected function recalculateCollisionBoxes() : array{
        //TODO: handle corners

        $minYSlab = ($this->meta & 0x04) === 0 ? 0 : 0.5;
        $maxYSlab = $minYSlab + 0.5;

        $bbs = [
            new AxisAlignedBB(
                $this->x,
                $this->y + $minYSlab,
                $this->z,
                $this->x + 1,
                $this->y + $maxYSlab,
                $this->z + 1
            )
        ];

        $minY = ($this->meta & 0x04) === 0 ? 0.5 : 0;
        $maxY = $minY + 0.5;

        $rotationMeta = $this->meta & 0x03;

        $minX = $minZ = 0;
        $maxX = $maxZ = 1;

        switch($rotationMeta){
            case 0:
                $minX = 0.5;
                break;
            case 1:
                $maxX = 0.5;
                break;
            case 2:
                $minZ = 0.5;
                break;
            case 3:
                $maxZ = 0.5;
                break;
        }

        $bbs[] = new AxisAlignedBB(
            $this->x + $minX,
            $this->y + $minY,
            $this->z + $minZ,
            $this->x + $maxX,
            $this->y + $maxY,
            $this->z + $maxZ
        );

        return $bbs;
    }
    public function getVariantBitmask() : int{
        return 0;
    }
    public function getHardness() : float{
        return 1.5;
    }

    public function getBlastResistance() : float{
        return 6;
    }
    
    public function getToolType(): int {
      return BlockToolType::TYPE_PICKAXE;
    }
    
    public function getToolHarvestLevel(): int {
      return TieredTool::TIER_WODDEN;
    }
    
    public function getFlameEncouragement() : int{
      return 5;
    }

    public function getFlammability() : int{
      return 20;
    }
}
