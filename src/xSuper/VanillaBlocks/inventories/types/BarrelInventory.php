<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\inventories\types;

use pocketmine\inventory\ContainerInventory;
use pocketmine\level\Position;
use pocketmine\network\mcpe\protocol\BlockEventPacket;
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
            $this->broadcastBlockEventPacket(true);
            $this->getHolder()->getLevelNonNull()->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), $this->getOpenSound());
        }
    }

    public function onClose(Player $who) : void{
        if(count($this->getViewers()) === 1 and $this->getHolder()->isValid()){
            $this->broadcastBlockEventPacket(false);
            $this->getHolder()->getLevelNonNull()->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), $this->getCloseSound());
        }
        parent::onClose($who);
    }

    // TODO: BARREL
    protected function broadcastBlockEventPacket(bool $isOpen) : void{
        $holder = $this->getHolder();

        $pk = new BlockEventPacket();
        $pk->x = (int) $holder->x;
        $pk->y = (int) $holder->y;
        $pk->z = (int) $holder->z;
        $pk->eventType = 3; //it's always 1 for a chest
        $pk->eventData = $isOpen ? 1 : 0;
        $holder->getLevelNonNull()->broadcastPacketToViewers($holder, $pk);
    }
}