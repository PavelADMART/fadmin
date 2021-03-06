<?php
namespace Rover\Fadmin\Inputs;

use Bitrix\Main;
use Bitrix\Main\Application;
use \Bitrix\Main\Config\Option;
use \Rover\Fadmin\Tab;
use \Rover\Fadmin\Options;

/**
 * Class Input
 *
 * @package Rover\Fadmin\Inputs
 * @author  Pavel Shulaev (http://rover-it.me)
 */
abstract class Input
{
    const TYPE__ADD_PRESET      = 'addpreset';
	const TYPE__CHECKBOX        = 'checkbox';
    const TYPE__CLOCK           = 'clock';
	const TYPE__COLOR           = 'color';
    const TYPE__CUSTOM          = 'custom';
    const TYPE__DATE            = 'date';
	const TYPE__DATETIME        = 'datetime';
    const TYPE__FILE            = 'file';
	const TYPE__HEADER          = 'header';
    const TYPE__HIDDEN          = 'hidden';
    const TYPE__IBLOCK          = 'iblock';
    const TYPE__LABEL           = 'label';
    const TYPE__NUMBER          = 'number';
    const TYPE__PRESET_NAME     = 'presetname';
    const TYPE__RADIO           = 'radio';
    const TYPE__REMOVE_PRESET   = 'removepreset';
    const TYPE__SELECTBOX       = 'selectbox';
    const TYPE__SELECT_GROUP    = 'selectgroup';
    const TYPE__SCHEDULE        = 'schedule';
    const TYPE__SUBMIT          = 'submit';
    const TYPE__TEXT            = 'text';
	const TYPE__TEXTAREA        = 'textarea';
	const TYPE__SUBTABCONTROL   = 'subtabcontrol';
	const TYPE__SUBTAB          = 'subtab';

    /** @var string */
	public static $type;

	/** input id */
	protected $id;

	/** @var string */
	protected $name;

	/** @var string */
	protected $label;

	/** @var string|array */
	protected $value;

	/** @var string|array */
	protected $default;

	/** @var bool */
	protected $multiple = false;

	/** @var string */
	protected $help;

	/** @var Tab */
	protected $tab;

	/** @var int */
	protected $sort = 500;

	/** @var bool */
	protected $hidden = false;

	/** @var bool */
	protected $disabled = false;

    /**
     * Input constructor.
     *
     * @param array $params
     * @param Tab   $tab
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     */
	public function __construct(array $params, Tab $tab)
	{
		if (is_null($params['name']))
			throw new Main\ArgumentNullException('name');

		if (preg_match('#[.]#usi', $params['name']))
		    throw new Main\ArgumentOutOfRangeException('name');

		if (is_null($params['label']))
			throw new Main\ArgumentNullException('label');

		if (is_null($params['id']))
			$params['id'] = $params['name'];

		$this->tab = $tab;

		$this->id   = htmlspecialcharsbx($params['id']);
		$this->name = htmlspecialcharsbx($params['name']);

		$this->setLabel($params['label']);
		$this->setDefault($params['default']);

		if (isset($params['multiple']))
			$this->multiple = (bool)$params['multiple'];

		if (isset($params['disabled']))
			$this->disabled = (bool)$params['disabled'];

		if (isset($params['help']))
			$this->help = $params['help'];

		if (isset($params['sort']) && intval($params['sort']))
			$this->sort = intval($params['sort']);

        if (array_key_exists('hidden', $params))
            $this->hidden = (bool)$params['hidden'];

		// @TODO: deprecated
		if (array_key_exists('display', $params))
			$this->hidden = !(bool)$params['display'];
	}

	/**
	 * @param $display
	 * @return $this
	 * @author Pavel Shulaev (http://rover-it.me)
     * @deprecated use setHidden()
	 */
	public function setDisplay($display)
	{
		$this->hidden = !(bool)$display;

		return $this;
	}

    /**
     * @param $hidden
     * @return $this
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public function setHidden($hidden)
	{
		$this->hidden = (bool)$hidden;

		return $this;
	}

    /**
     * @return bool
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public function isHidden()
    {
        return $this->hidden;
    }

	/**
	 * @return bool
	 * @author Pavel Shulaev (http://rover-it.me)
     * @deprecated use isHidden()
	 */
	public function getDisplay()
	{
		return !$this->hidden;
	}


	/**
	 * @return int
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getSort()
	{
		return $this->sort;
	}

	/**
	 * @param $sort
	 * @return $this
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function setSort($sort)
	{
		$this->sort = intval($sort);

		return $this;
	}

	/**
	 * @param Tab $tab
	 * @return $this
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function setTab(Tab $tab)
	{
		$this->tab = $tab;

		return $this;
	}

	/**
	 * @return Tab
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getTab()
	{
		return $this->tab;
	}

	/**
	 * @param array $params
	 * @param Tab   $tab
	 * @return Input
	 * @throws Main\SystemException
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public static function factory(array $params, Tab $tab)
	{
		$className = '\Rover\Fadmin\Inputs\\' . ucfirst($params['type']);

		if (!class_exists($className))
			throw new Main\SystemException('Class "' . $className . '" not found!');

		if ($className == '\Rover\Fadmin\Inputs\Input')
			throw new Main\SystemException('Can\'t create "' . $className . '" instance');

		$input = new $className($params, $tab);

		if ($input instanceof Input === false)
			throw new Main\SystemException('"' . $className . '" is not "\Rover\Fadmin\Inputs\Input" instance');

		return $input;
	}

	/**
	 * @return mixed
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @param $label
	 * @return $this
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function setLabel($label)
	{
		$this->label = trim($label);

		return $this;
	}

	/**
	 * @return mixed
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getDefault()
	{
		return $this->default;
	}

	/**
	 * @param $default
	 * @return $this
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function setDefault($default)
	{
		if (is_array($default))
			$default = serialize($default);

		$this->default = trim($default);

		return $this;
	}

	/**
	 * @return bool
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function isMultiple()
	{
		return $this->multiple;
	}

	/**
	 * @param $value
	 * @return $this
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function setHelp($value)
	{
		$this->help = $value;

		return $this;
	}

	/**
	 * @return string
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getHelp()
	{
		return $this->help;
	}

	/**
	 * @param $value
	 * @return $this
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function setDisabled($value)
	{
		$this->disabled = (bool)$value;

		return $this;
	}

	/**
	 * @return bool
	 * @author Pavel Shulaev (http://rover-it.me)
     * @deprecated use isDisabled
	 */
	public function getDisabled()
	{
		return $this->disabled;
	}

	/**
	 * @return bool
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function isDisabled()
	{
		return $this->disabled;
	}

    /**
     * @param $value
     * @return $this
     * @throws Main\SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public function setValue($value)
	{
		if ($this->disabled)
			throw new Main\SystemException('input is disabled');

		$this->value = $this->saveValue($value)
		    ? $value
			: null;

		return $this;
	}

    /**
     * @param $value
     * @return bool
     * @throws Main\ArgumentOutOfRangeException
     * @author Pavel Shulaev (https://rover-it.me)
     */
	private function saveValue($value)
    {
        if (!static::beforeSaveValue($value))
            return false;

		Option::set($this->tab->getModuleId(), $this->getValueName(), $value, $this->tab->getSiteId());

		return true;
	}

	/**
	 * @throws Main\ArgumentNullException
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function removeValue()
	{
		$this->value = null;
		$filter      = array(
		    'name' => $this->getValueName(),
            'site_id' => $this->tab->getSiteId()
        );

		Option::delete($this->tab->getModuleId(), $filter);
	}

	/**
	 * @return Options
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	protected function getOptions()
	{
		return $this->tab->options;
	}

    /**
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public function loadValue()
	{
		$this->value = Option::get($this->tab->getModuleId(),
			$this->getValueName(), $this->default, $this->tab->getSiteId());

		if ($this->multiple) {
			if (!is_array($this->value))
				$this->value = unserialize($this->value);

			if (!$this->value)
				$this->value = array();
		}

		static::afterLoadValue($this->value);
	}

    /**
     * @param array  $params
     * @param        $moduleId
     * @param string $presetId
     * @param string $siteId
     * @return string
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public static function getValueStatic(array $params, $moduleId, $presetId = '', $siteId = '')
	{
		if (!isset($params['name']))
			throw new Main\ArgumentNullException('name');

		if (!isset($params['default']))
			$params['default'] = null;

		return Option::get($moduleId,
			Options::getFullName($params['name'], $presetId, $siteId),
			$params['default'], $siteId);
	}

    /**
     * @param bool $reload
     * @return array|string
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public function getValue($reload = false)
	{
		if (empty($this->value) || $reload)
			$this->loadValue();

		if (!static::beforeGetValue($this->value))
		    return null;

		return $this->value;
	}

	/**
	 * @return mixed
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getType()
	{
		return static::$type;
	}

	/**
	 * @return string
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getValueId()
	{
		return Options::getFullName($this->id,
			$this->tab->getPresetId(), $this->tab->getSiteId());
	}


	/**
	 * @return string
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getValueName()
	{
		return Options::getFullName($this->name,
			$this->tab->getPresetId(), $this->tab->getSiteId());
	}

	/**
	 * @return mixed
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getName()
	{
		return $this->name;
	}

    /**
     * @return bool
     * @throws Main\SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public function setValueFromRequest()
	{
	    if ($this->isDisabled())
	        return false;

		$request = Application::getInstance()
			->getContext()
			->getRequest();

		if ((!$request->offsetExists($this->getValueName())
			&& ($this->getType() != self::TYPE__CHECKBOX))
            && ($this->getType() != self::TYPE__FILE))
			return false;

		$value = $request->get($this->getValueName());

		// EVENT: beforeSaveRequest
        if (!static::beforeSaveRequest($value))
            return false;

		//serialize multiple value
		if ($this->multiple && is_array($value))
			$value = serialize($value);

		$this->setValue($value);

		return true;
	}

	/**
	 * @return string
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function getModuleId()
	{
		return $this->tab->getModuleId();
	}

    /**
     * @return string
     * @author Pavel Shulaev (https://rover-it.me)
     */
	public static function getClassName()
    {
        return get_called_class();
    }

    /**
     * @param $value
     * @return mixed
     * @author Pavel Shulaev (https://rover-it.me)
     * @internal
     */
    protected function beforeSaveRequest(&$value)
    {
        return true;
    }

    /**
     * @param $value
     * @return mixed
     * @author Pavel Shulaev (https://rover-it.me)
     * @internal
     */
    protected function beforeGetValue(&$value)
    {
        return true;
    }

    /**
     * @param $value
     * @author Pavel Shulaev (https://rover-it.me)
     * @internal
     */
    protected function afterLoadValue(&$value) {}

    /**
     * @param $value
     * @return bool
     * @author Pavel Shulaev (https://rover-it.me)
     * @internal
     */
    protected function beforeSaveValue(&$value)
    {
        return true;
    }
}