<?php

namespace xSuper\VanillaBlocks\blocks\overrides;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use pocketmine\block\Block;
use pocketmine\block\Wood;
use pocketmine\item\Axe;
use pocketmine\item\Item;
use pocketmine\Player;
use xSuper\VanillaBlocks\blocks\StrippedLogBlock;
use xSuper\VanillaBlocks\blocks\VanillaBlockIds;

class LogBlock extends Wood {
    public function onActivate(Item $item, Player $player = null): bool
    {
        if ($item instanceof Axe) {
            $this->getLevel()->setBlock($this, new Placeholder($this->getStrippedVariant()), true);
            $item->applyDamage(1);
            if (!$player->isCreative()) $player->getInventory()->setItemInHand($item);
        }

        return parent::onActivate($item, $player);
    }

    public function getStrippedVariant(): Block
    {
        switch ($this->meta & 0x03) {
            case self::OAK:
                $block = new StrippedLogBlock(VanillaBlockIds::STRIPPED_OAK, "Stripped Oak Log", $this->translateMeta());
                break;
            case self::SPRUCE:
                $block = new StrippedLogBlock(VanillaBlockIds::STRIPPED_SPRUCE, "Stripped Spruce Log", $this->translateMeta());
                break;
            case self::BIRCH:
                $block = new StrippedLogBlock(VanillaBlockIds::STRIPPED_BIRCH, "Stripped Birch Log", $this->translateMeta());
                break;
            case self::JUNGLE:
                $block = new StrippedLogBlock(VanillaBlockIds::STRIPPED_JUNGLE, "Stripped Jungle Log", $this->translateMeta());
                break;
            default:
                $block = Block::get(Block::AIR);
        }

        $block->position($this);
        return $block;
    }

    public function translateMeta(): int
    {
        switch ($this->meta & 0x03) {
            case self::OAK:
                if ($this->meta === 0) return 0;
                if ($this->meta === 4) return 1;
                if ($this->meta === 8) return 2;
                break;
            case self::BIRCH:
                if ($this->meta === 2) return 0;
                if ($this->meta === 6) return 1;
                if ($this->meta === 10) return 2;
                break;
            case self::SPRUCE:
                if ($this->meta === 1) return 0;
                if ($this->meta === 5) return 1;
                if ($this->meta === 9) return 2;
                break;
            case self::JUNGLE:
                if ($this->meta === 3) return 0;
                if ($this->meta === 7) return 1;
                if ($this->meta === 11) return 2;
                break;
         }

         return 0;
    }
}




