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

class CoralFanBlock extends Transparent {
    use PlaceholderTrait;

    public function __construct(int $id, string $name, int $meta = 0)
    {
        parent::__construct($id, $meta, $name);
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
        if ($face !== Vector3::SIDE_UP && $face !== Vector3::SIDE_DOWN) {
            if ($this->id === VanillaBlockIds::DEAD_CORAL_FAN) $block = $this->getDeadWallVersion($face);
            else $block = $this->getAliveWallVersion($face);
            $this->getLevel()->setBlock($blockReplace, new Placeholder($block), true, true);
            return true;
        } else if ($face === Vector3::SIDE_UP) {
            if ($this->id === VanillaBlockIds::DEAD_CORAL_FAN) $block = $this->getDeadFloorVersion();
            else $block = $this->getAliveFloorVersion();
            $this->getLevel()->setBlock($blockReplace, new Placeholder($block), true, true);
            return true;
        }
        return false;
    }

    public function getAliveFloorVersion(): Block
    {
        $block = Block::get(Block::AIR);
        switch ($this->meta) {
            case 0:
                $block = new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Tube Coral Fan");
                break;
            case 1:
                $block = new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Brain Coral Fan", 1);
                break;
            case 2:
                $block = new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Bubble Coral Fan", 2);
                break;
            case 3:
                $block = new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Fire Coral Fan", 3);
                break;
            case 4:
                $block = new CoralFanBlock(VanillaBlockIds::CORAL_FAN, "Horn Coral Fan", 4);
                break;
        }

        $block->position($this);
        return $block;
    }

    public function getAliveWallVersion(int $face): Block
    {
        $block = Block::get(Block::AIR);
        switch ($face) {
            case Vector3::SIDE_EAST:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Tube Coral Wall", 4);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Brain Coral Wall", 5);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Bubble Coral Wall", 4);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Fire Coral Wall", 5);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Horn Coral Wall", 4);
                        break;
                }
                break;
            case Vector3::SIDE_WEST:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Tube Coral Wall", 0);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Brain Coral Wall", 1);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Bubble Coral Wall", 0);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Fire Coral Wall", 1);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Horn Coral Wall", 0);
                        break;
                }
                break;
            case Vector3::SIDE_NORTH:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Tube Coral Wall", 8);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Brain Coral Wall", 9);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Bubble Coral Wall", 8);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Fire Coral Wall", 9);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Horn Coral Wall", 8);
                        break;
                }
                break;
            case Vector3::SIDE_SOUTH:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Tube Coral Wall", 12);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Brain Coral Wall", 13);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Bubble Coral Wall", 12);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Fire Coral Wall", 13);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Horn Coral Wall", 12);
                        break;
                }
                break;
        }

        $block->position($this);
        return $block;
    }

    public function getDeadFloorVersion(): Block
    {
        $block = Block::get(Block::AIR);
        switch ($this->meta) {
            case 0:
                $block = new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Tube Coral Fan");
                break;
            case 1:
                $block = new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Brain Coral Fan", 1);
                break;
            case 2:
                $block = new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Bubble Coral Fan", 2);
                break;
            case 3:
                $block = new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Fire Coral Fan", 3);
                break;
            case 4:
                $block = new CoralFanBlock(VanillaBlockIds::DEAD_CORAL_FAN, "Dead Horn Coral Fan", 4);
                break;
        }

        $block->position($this);
        return $block;
    }

    public function getDeadWallVersion($face): Block
    {
        $block = Block::get(Block::AIR);
        switch ($face) {
            case Vector3::SIDE_EAST:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Tube Coral Wall", 6);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Brain Coral Wall", 7);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Bubble Coral Wall", 6);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Fire Coral Wall", 7);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Dead Horn Coral Wall", 6);
                        break;
                }
                break;
            case Vector3::SIDE_WEST:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Tube Coral Wall", 2);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Brain Coral Wall", 3);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Bubble Coral Wall", 2);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Fire Coral Wall", 3);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Dead Horn Coral Wall", 2);
                        break;
                }
                break;
            case Vector3::SIDE_NORTH:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Tube Coral Wall", 10);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Brain Coral Wall", 11);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Bubble Coral Wall", 10);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Fire Coral Wall", 11);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Dead Horn Coral Wall", 10);
                        break;
                }
                break;
            case Vector3::SIDE_SOUTH:
                switch ($this->meta) {
                    case 0:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Tube Coral Wall", 14);
                        break;
                    case 1:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_1, "Dead Brain Coral Wall", 15);
                        break;
                    case 2:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Bubble Coral Wall", 14);
                        break;
                    case 3:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_2, "Dead Fire Coral Wall", 15);
                        break;
                    case 4:
                        $block = new CoralFanBlock(VanillaBlockIds::CORAL_WALL_FAN_3, "Dead Horn Coral Wall", 14);
                        break;
                }
                break;
        }

        $block->position($this);
        return $block;
    }

    public function getPickedItem(): Item
    {
        if ($this->isDead()) $id = VanillaBlockIds::DEAD_CORAL_FAN;
        else $id = VanillaBlockIds::CORAL_FAN;
        return ItemFactory::get(255 - $id, $this->getMetaFromType());
    }

    public function isDead(): bool
    {
        if ($this->id === VanillaBlockIds::DEAD_CORAL_FAN) return true;
        if (in_array($this->id, [VanillaBlockIds::CORAL_WALL_FAN_1, VanillaBlockIds::CORAL_WALL_FAN_2, VanillaBlockIds::CORAL_WALL_FAN_3])) {
            if (in_array($this->meta, [6, 7, 2, 3, 10, 11, 14, 15])) return true;
        }
        return false;
    }

    public function getMetaFromType(): int
    {
        if ($this->id === VanillaBlockIds::CORAL_WALL_FAN_1) {
            if (in_array($this->meta, [0, 2, 4, 6, 8, 10, 12, 14])) return 0;
            else return 1;
        } else if ($this->id === VanillaBlockIds::CORAL_WALL_FAN_2) {
            if (in_array($this->meta, [0, 2, 4, 6, 8, 10, 12, 14])) return 2;
            else return 3;
        } else if ($this->id === VanillaBlockIds::CORAL_WALL_FAN_3) return 4;
        else return $this->meta;
    }
}





