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
    public $record = null;

    private $finishedPlaying = false;

    private $recordDuration = 0;
    private $recordMaxDuration = -1;

    public function onInteract(Item $item, Player $player = null)
    {
        if($this->hasRecord()) $this->updateRecord();
        else if($item instanceof RecordItem) $this->updateRecord($item, $player);

        $this->scheduleUpdate();
    }

    public function onBreak()
    {
        if($this->hasRecord()) $this->updateRecord();
    }

    public function updateRecord(Item $record = null, Player $player = null)
    {
        if($record === null) $this->dropRecord();
        else if ($record instanceof RecordItem) {
            $player->getInventory()->removeItem($record);

            $this->record = $record;
            $this->recordDuration = 0;
            $this->finishedPlaying = false;

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
        if($this->hasRecord()){
            $this->getLevel()->dropItem($this->asVector3(), $this->record);
            $this->record = null;
            $this->recordDuration = 0;
            $this->stopSound();
        }
    }

    public function validateDuration(): void{
        if($this->recordDuration >= $this->recordMaxDuration){
            $this->finishedPlaying = true;
        }
    }

    public function stopSound(): void
    {
        $this->getLevel()->broadcastLevelSoundEvent($this, LevelSoundEventPacket::SOUND_STOP_RECORD);
    }

    public function onUpdate(): bool
    {
        if ($this->hasRecord() && !$this->finishedPlaying) {
            if ($this->recordMaxDuration === -1) $this->recordMaxDuration = RecordItem::getRecordLength($this->record->getId()) * 20; 

            $this->recordDuration++;
            $this->validateDuration();

            if ($this->finishedPlaying) return false;
            if (Server::getInstance()->getTick() % 30 === 0) $this->getLevel()->addParticle(new GenericParticle($this->add(0.5, 1.25, 0.5), Particle::TYPE_NOTE));
            return true;
        }
        return false;
    }

    public function hasRecord(): bool
    {
        return $this->record !== null;
    }

    public function readSaveData(CompoundTag $nbt): void
    {
        if($nbt->hasTag("RecordItem")) $this->record = Item::nbtDeserialize($nbt->getCompoundTag("RecordItem"));
        if($nbt->hasTag("RecordDuration")) $this->recordDuration = $nbt->getInt("RecordDuration");
    }

    protected function writeSaveData(CompoundTag $nbt): void
    {
        if($this->record !== null) $nbt->setTag($this->record->nbtSerialize(-1, "RecordItem"));
        $nbt->setInt("RecordDuration", $this->recordDuration);
    }

    protected function addAdditionalSpawnData(CompoundTag $nbt): void
    {

    }
}
