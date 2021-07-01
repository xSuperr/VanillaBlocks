<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\block\Solid;
use pocketmine\math\Vector3;
use pocketmine\block\BlockToolType;
use pocketmine\tile\Tile;
use xSuper\VanillaBlocks\blocks\tiles\JukeboxTile;

class JukeboxBlock extends Solid {

    public function __construct()
    {
        parent::__construct(VanillaBlockIds::JUKEBOX, 0, "Jukebox");
    }

    public function getFlammability(): int
    {
        return 2;
    }

    public function getHardness(): float
    {
        return 2.0;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_AXE;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool
    {
        $this->getLevel()->setBlock($this, $this, true, true);
        if ($this->getLevelNonNull()->getTile($this) === null) Tile::createTile("Jukebox", $this->getLevel(), JukeboxTile::createNBT($this, 0, $item, $player));
        return true;
    }

    public function onActivate(Item $item, Player $player = null): bool
    {
        if ($this->getLevelNonNull()->getTile($this) === null) $tile = Tile::createTile("Jukebox", $this->getLevel(), JukeboxTile::createNBT($this, 0, $item, $player));
        else $tile = $this->getLevelNonNull()->getTile($this);
        if ($tile instanceof JukeboxTile) $tile->onInteract($item, $player);
        return true;
    }

    public function onBreak(Item $item, Player $player = null): bool
    {
        if ($this->getLevelNonNull()->getTile($this) === null) $tile = Tile::createTile("Jukebox", $this->getLevel(), JukeboxTile::createNBT($this, 0, $item, $player));
        else $tile = $this->getLevelNonNull()->getTile($this);
        if ($tile instanceof JukeboxTile) $tile->onBreak();
        return parent::onBreak($item, $player);
    }
}
