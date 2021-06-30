<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\inventories\types;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use pocketmine\inventory\ContainerInventory;
use pocketmine\level\Position;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\Player;
use xSuper\VanillaBlocks\blocks\tiles\BarrelTile;
use function count;

class BarrelInventory extends ContainerInventory
{
    /** @var BarrelTile */
    protected $holder;

    public function __construct(BarrelTile $tile){
        parent::__construct($tile);
    }

    public function getNetworkType() : int{
        return WindowTypes::CONTAINER;
    }

    public function getName() : string{
        return "Barrel";
    }

    public function getDefaultSize() : int{
        return 27;
    }

    /**
     * @return BarrelTile|Position
     */
    public function getHolder(){
        return $this->holder;
    }

    protected function getOpenSound() : int{
        return LevelSoundEventPacket::SOUND_BLOCK_BARREL_OPEN;
    }

    protected function getCloseSound() : int{
        return LevelSoundEventPacket::SOUND_BLOCK_BARREL_CLOSE;
    }

    public function onOpen(Player $who) : void{
        parent::onOpen($who);

        if(count($this->getViewers()) === 1 and $this->getHolder()->isValid()){
            $this->getHolder()->getLevelNonNull()->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), $this->getOpenSound());
        }

        /** @var BarrelTile $holder */
        $holder = $this->getHolder();

        $block = $holder->getBlock();
        if ($block instanceof Placeholder) {
            $block = $this->holder->getBlock(true);
            $meta = $block->getDamage();
            $block->setDamage(($meta & 0x07) | (0x08));
            $this->holder->getLevelNonNull()->setBlock($this->holder, new Placeholder($block, $this->getHolder()), true);
        }
    }

    public function onClose(Player $who) : void{
        $holder = $this->getHolder();
        if ($holder instanceof BarrelTile && !$holder->isClosed()) {
            if(count($this->getViewers()) === 1 and $this->getHolder()->isValid()){
                $this->getHolder()->getLevelNonNull()->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), $this->getCloseSound());
            }
            $block = $holder->getBlock();
            if ($block instanceof Placeholder) {
                $block = $this->holder->getBlock(true);
                $meta = $block->getDamage();
                $block->setDamage(($meta & 0x07) | (0));
                $holder->setInventory($this);
                $this->holder->getLevelNonNull()->setBlock($this->holder, new Placeholder($block, $this->getHolder()), true);
            }
        }

        parent::onClose($who);
    }
}