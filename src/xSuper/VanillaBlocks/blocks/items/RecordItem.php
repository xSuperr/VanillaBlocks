<?php

namespace xSuper\VanillaBlocks\blocks\items;

use pocketmine\item\Item;

class RecordItem extends Item {

    private $soundId;
    private $soundName;

    public function __construct(int $id, string $name, int $soundId)
    {
        $this->soundName = $name;
        $this->soundId = $soundId;

        parent::__construct($id);
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }

    public function getSoundName(): string
    {
        return $this->soundName;
    }

    public function getSoundId(): int
    {
        return $this->soundId;
    }
}
