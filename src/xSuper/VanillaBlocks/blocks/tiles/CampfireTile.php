<?php

namespace xSuper\VanillaBlocks\blocks\tiles;

use JavierLeon9966\ExtendedBlocks\item\ItemFactory;
use JavierLeon9966\ExtendedBlocks\tile\PlaceholderInterface;
use JavierLeon9966\ExtendedBlocks\tile\PlaceholderTrait;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\tile\Spawnable;
use xSuper\VanillaBlocks\VanillaBlocks;

class CampfireTile extends Spawnable implements PlaceholderInterface {
    use PlaceholderTrait;

    /** @var ?Item */
    private $Item1 = null;
    /** @var ?Item */
    private $Item2 = null;
    /** @var ?Item */
    private $Item3 = null;
    /** @var ?Item */
    private $Item4 = null;

    /** @var int */
    private $ItemTime1 = 0;
    /** @var int */
    private $ItemTime2 = 0;
    /** @var int */
    private $ItemTime3 = 0;
    /** @var int */
    private $ItemTime4 = 0;

    /**
     * @var bool
     * Checks if the campfire is updating
     */
    private $ticking = false;

    public function __construct(Level $level, CompoundTag $nbt)
    {
        $task = VanillaBlocks::getInstance()->getScheduler()->scheduleRepeatingTask(new ClosureTask(function () use (& $task): void{
            if ($this->closed) {
                $task->cancel();
                return;
            }

            $this->ticking = false;
            $this->scheduleUpdate();
        }), 20);
        parent::__construct($level, $nbt);
    }


    public function getName(): string{
        return "Campfire";
    }

    protected function readSaveData(CompoundTag $nbt): void{
        $this->loadBlock($nbt);

        for($i = 1; $i <= 4; ++$i){
            if (($item = $nbt->getCompoundTag("Item$i")) !== null) {
                $this->{"Item$i"} = Item::nbtDeserialize($item);
            }
        }
        $this->ItemTime1 = $nbt->getInt("ItemTime1");
        $this->ItemTime2 = $nbt->getInt("ItemTime2");
        $this->ItemTime3 = $nbt->getInt("ItemTime3");
        $this->ItemTime4 = $nbt->getInt("ItemTime4");
    }

    protected function writeSaveData(CompoundTag $nbt): void{
        $this->saveBlock($nbt);

        for($i = 1; $i <= 4; ++$i){
            if($this->{"Item$i"} !== null){
                $nbt->setTag($this->{"Item$i"}->nbtSerialize(-1, "Item$i"));
            }
        }
        $nbt->setInt('ItemTime1', $this->ItemTime1);
        $nbt->setInt('ItemTime2', $this->ItemTime2);
        $nbt->setInt('ItemTime3', $this->ItemTime3);
        $nbt->setInt('ItemTime4', $this->ItemTime4);
    }

    protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
        for($i = 1; $i <= 4; ++$i){
            if($this->{"Item$i"} !== null){
                $nbt->setTag($this->{"Item$i"}->nbtSerialize(-1, "Item$i"));
            }
        }

        $nbt->setInt('ItemTime1', $this->ItemTime1);
        $nbt->setInt('ItemTime2', $this->ItemTime2);
        $nbt->setInt('ItemTime3', $this->ItemTime3);
        $nbt->setInt('ItemTime4', $this->ItemTime4);
    }

    public function canAddItem(Item $item): bool
    {
        if (!in_array($item->getId(), [Item::RAW_RABBIT, Item::RAW_MUTTON, Item::RAW_FISH, Item::RAW_CHICKEN, Item::RAW_BEEF, Item::RAW_PORKCHOP, Item::RAW_SALMON])) return false;
        for($i = 1; $i <= 4; ++$i){
            if($this->{"Item$i"} === null) return true;
        }

        return false;
    }

    public function addItem(Item $item): void
    {
        for($i = 1; $i <= 4; ++$i){
            if($this->{"Item$i"} === null) {
                $this->{"Item$i"} = $item;
                $this->{"ItemTime$i"} = 30;
                $this->onChanged();
                return;
            }
        }
    }

    public function onUpdate(): bool
    {
        if ($this->closed) return false;
        if ($this->ticking) return false;

        for ($i = 1; $i <= 4; ++$i) {
            $ItemTime = $this->{"ItemTime$i"};
            $Item = $this->{"Item$i"};

            if ($Item !== null) {
                $this->ticking = true;

                --$this->{"ItemTime$i"};

                if ($ItemTime <= 0) {
                    $result = $this->getResult($Item);

                    $this->getLevelNonNull()->dropItem($this, $result);
                    $this->{"Item$i"} = null;
                    $this->onChanged();
                }
            }
        }

        return true;
    }

    public function getResult(Item $item): ?Item
    {
        switch ($item->getId()) {
            case Item::RAW_PORKCHOP:
                return ItemFactory::get(Item::COOKED_PORKCHOP);
            case Item::RAW_BEEF:
                return ItemFactory::get(Item::COOKED_BEEF);
            case Item::RAW_CHICKEN:
                return ItemFactory::get(Item::COOKED_CHICKEN);
            case Item::RAW_FISH:
                return ItemFactory::get(Item::COOKED_FISH);
            case Item::RAW_MUTTON:
                return ItemFactory::get(Item::COOKED_MUTTON);
            case Item::RAW_RABBIT:
                return ItemFactory::get(Item::COOKED_RABBIT);
            case Item::RAW_SALMON:
                return ItemFactory::get(Item::COOKED_SALMON);
        }

        return null;
    }

    public function getItems(): array
    {
        $items = [];
        for($i = 1; $i <= 4; ++$i){
            if($this->{"Item$i"} !== null){
                $items[] = $this->{"Item$i"}->setCount(1);
            } else $items[] = ItemFactory::get(Item::AIR, 0, 0);
        }

        return $items;
    }
}

