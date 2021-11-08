<?php

declare(strict_types=1);

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Solid;
use pocketmine\block\BlockToolType;
use pocketmine\Player;

/**
 * Block minecraft:bee_nest
 */
class BeeNest extends Solid
{
	use PlaceholderTrait;

	protected $id = VanillaBlockIds::BEE_NEST;
	protected $meta = 0;
	protected $name = "Bee Nest";

	function __construct($id, $name, $meta = 0)
	{
		parent::__construct($id, $meta, $name);
	}

	public function getBlastResistance(): float
    {
        return 0.3;
    }

    public function getHardness(): float
    {
        return 0.3;
    }

    public function getToolType(): int
    {
        return BlockToolType::TYPE_AXE;
    }

    public function getToolHarvestLevel(): int
    {
        return TieredTool::TIER_WOODEN;
    }

    function place($item, $blockReplace, $blockClicked, int $face, $clickVector, $player = null) : bool{

		$this->meta = $player instanceof Player ? ($player->getDirection() + 1 == 4 ? 0 : $player->getDirection() + 1) : 0;

		$this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true, true);

		return true;
	}
}