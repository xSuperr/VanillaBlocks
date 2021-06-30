<?php

namespace xSuper\VanillaBlocks\blocks\tiles;


use JavierLeon9966\ExtendedBlocks\tile\PlaceholderInterface;
use JavierLeon9966\ExtendedBlocks\tile\PlaceholderTrait;
use pocketmine\inventory\InventoryHolder;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\tile\Container;
use pocketmine\tile\ContainerTrait;
use pocketmine\tile\Spawnable;
use xSuper\VanillaBlocks\inventories\types\BarrelInventory;

class BarrelTile extends Spawnable implements InventoryHolder, Container, PlaceholderInterface {
    use ContainerTrait;
    use PlaceholderTrait;

    /** @var BarrelInventory */
    private $inventory;

    public function getName(): string{
        return "Barrel";
    }

    public function setInventory(BarrelInventory $inventory): void
    {
        $this->inventory = $inventory;
    }

    public function getInventory(): BarrelInventory
    {
        return $this->inventory;
    }

    public function getRealInventory(): BarrelInventory
    {
        return $this->inventory;
    }

    protected function readSaveData(CompoundTag $nbt): void{
        $this->inventory = new BarrelInventory($this);
        $this->loadItems($nbt);
        $this->loadBlock($nbt);
    }

    protected function writeSaveData(CompoundTag $nbt): void{
        $this->saveItems($nbt);
        $this->saveBlock($nbt);
    }

    protected function addAdditionalSpawnData(CompoundTag $nbt): void{
    }

    public function close() : void
    {
        if (!$this->closed) {
            $this->closed = true;

            if ($this->isValid()) {
                $this->level->removeTile($this);
                $this->setLevel();
            }

            $this->inventory->removeAllViewers(true);
        }
    }
}
