<?php

namespace xSuper\VanillaBlocks\blocks\overrides;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use pocketmine\block\Block;
use pocketmine\block\Wood2;
use pocketmine\item\Axe;
use pocketmine\item\Item;
use pocketmine\Player;
use xSuper\VanillaBlocks\blocks\StrippedLogBlock;
use xSuper\VanillaBlocks\blocks\VanillaBlockIds;

class LogBlock2 extends Wood2 {
    public function onActivate(Item $item, Player $player = null): bool
    {
        if ($item instanceof Axe) {
            $this->getLevel()->setBlock($this, new Placeholder($this->getStrippedVariant()), true);
            $item->applyDamage(1);
        }

        return parent::onActivate($item, $player);
    }

    public function getStrippedVariant(): Block
    {
        switch ($this->meta & 0x03) {
            case self::ACACIA:
                $block = new StrippedLogBlock(VanillaBlockIds::STRIPPED_ACACIA, "Stripped Acacia Log", $this->translateMeta());
                break;
            case self::DARK_OAK:
                $block = new StrippedLogBlock(VanillaBlockIds::STRIPPED_DARK_OAK, "Stripped Dark Oak Log", $this->translateMeta());
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
            case self::ACACIA:
                if ($this->meta === 0) return 0;
                if ($this->meta === 4) return 1;
                if ($this->meta === 8) return 2;
                break;
            case self::DARK_OAK:
                if ($this->meta === 1) return 0;
                if ($this->meta === 5) return 1;
                if ($this->meta === 9) return 2;
                break;
        }

        return 0;
    }
}





