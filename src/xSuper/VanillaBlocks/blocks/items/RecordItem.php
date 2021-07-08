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

    /**
     * @param int $id
     * @return int
     * This is in seconds
     */
    public static function getRecordLength(int $id): int{
        switch($id){
            case self::RECORD_CHIRP:
            case self::RECORD_CAT:
                return (60 * 3) + 5;
            case self::RECORD_BLOCKS:
                return (60 * 5) + 45;
            case self::RECORD_FAR:
                return (60 * 2) + 54;
            case self::RECORD_MALL:
                return (60 * 3) + 17;
            case self::RECORD_MELLOHI:
                return 60 + 36;
            case self::RECORD_STAL:
                return (60 * 2) + 30;
            case self::RECORD_STRAD:
                return (60 * 3) + 8;
            case self::RECORD_WARD:
                return (60 * 4) + 11;
            case self::RECORD_11:
                return 60 + 11;
            case self::RECORD_WAIT:
                return (60 * 3) + 51;
            case 759:
                return (60 * 2) + 28;
            default:
                return (60 * 2) + 58;
        }
    }
}
