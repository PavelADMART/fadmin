<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 11.01.2016
 * Time: 18:02
 *
 * @author Pavel Shulaev (http://rover-it.me)
 */

namespace Rover\Fadmin\Inputs;
/**
 * Class Color
 *
 * @package Rover\Fadmin\Inputs
 * @author  Pavel Shulaev (http://rover-it.me)
 */
class Color extends Input
{
	/**
	 * @var string
	 */
	public static $type = self::TYPE__COLOR;

	/**
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function draw()
	{
		$valueId    = $this->getValueId();
		$valueName  = $this->getValueName();

		$this->showLabel($valueId);

		?><input
			<?=$this->disabled ? 'disabled="disabled"': '';?>
			id="<?=$valueId?>"
			type="color"
			value="<?=$this->value?>"
			name="<?=$valueName?>"><?php

		$this->showHelp();
	}
}