<?php

namespace xSuper\VanillaBlocks\blocks\tiles;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\tile\Spawnable;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\TextPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use xSuper\VanillaBlocks\blocks\items\RecordItem;

class JukeboxTile extends Spawnable {
    public $has_record = false;
    public $record = null;

    public function onInteract(Item $item, Player $player = null)
    {
        if($this->has_record) $this->updateRecord();
        else if($item instanceof RecordItem) $this->updateRecord($item, $player);

        $this->scheduleUpdate();
    }

    public function onBreak()
    {
        if($this->has_record) $this->updateRecord();
    }

    public function updateRecord(Item $record = null, Player $player = null)
    {
        if($record == null) $this->dropRecord();
        else if ($record instanceof RecordItem) {
            $player->getInventory()->removeItem($record);

            $this->record = $record;
            $this->has_record = true;

            $this->getLevel()->broadcastLevelSoundEvent($this, $record->getSoundId());

            $pk = new TextPacket();
            $pk->type = TextPacket::TYPE_JUKEBOX_POPUP;
            $pk->message = "Now playing: " . $record->getSoundName();
            $player->dataPacket($pk);
        }
        $this->onChanged();
    }

    public function dropRecord()
    {
        if($this->has_record){
            $this->getLevel()->dropItem($this->asVector3(), $this->record);
            $this->has_record = false;
            $this->record = null;
            $this->stopSound();
        }
    }

    public function stopSound(): void
    {
        $this->getLevel()->broadcastLevelSoundEvent($this, LevelSoundEventPacket::SOUND_STOP_RECORD);
    }

    public function onUpdate(): bool
    {
        if($this->has_record && Server::getInstance()->getTick() % 30 === 0) $this->getLevel()->addParticle(new GenericParticle($this->add(0.5, 1.25, 0.5), Particle::TYPE_NOTE));
        return true;
    }

    public function readSaveData(CompoundTag $nbt): void
    {
        if($nbt->hasTag("Record")) $this->record = Item::nbtDeserialize($nbt->getCompoundTag("Record"));
    }

    protected function writeSaveData(CompoundTag $nbt): void
    {
        if($this->record !== null) $nbt->setTag($this->record->nbtSerialize(-1, "Record"));
    }

    protected function addAdditionalSpawnData(CompoundTag $nbt): void
    {

    }
}
