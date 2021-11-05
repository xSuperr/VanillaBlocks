<?php

namespace xSuper\VanillaBlocks\blocks;

use JavierLeon9966\ExtendedBlocks\block\Placeholder;
use JavierLeon9966\ExtendedBlocks\block\PlaceholderTrait;
use pocketmine\block\Stair as PM_Stair;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\Player;

class Stair extends PM_Stair
{
	use PlaceholderTrait;

	protected $id;
	protected $name;
	protected $meta;
	
	public function __construct(int $id, string $name, int $meta = 0)
	{
		$this->id = $id;
		$this->name = $name;
		$this->meta = $meta;

		parent::__construct($id, $meta, $name);
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool
	{
		$faces = [
			0 => 0,
			1 => 2,
			2 => 1,
			3 => 3
		];
		$this->meta = $player !== null ? $faces[$player->getDirection()] & 0x03 : 0;
		if(($clickVector->y > 0.5 and $face !== Vector3::SIDE_UP) or $face === Vector3::SIDE_DOWN){
			$this->meta |= 0x04;
		}
		$this->getLevelNonNull()->setBlock($blockReplace, new Placeholder($this), true, true);

		return true;
	}
}
