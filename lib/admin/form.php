<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.01.2016
 * Time: 20:10
 *
 * @author Pavel Shulaev (http://rover-it.me)
 */

namespace Rover\Fadmin\Admin;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Rover\Fadmin\Options;
use Rover\Fadmin\Tab;
/**
 * Class Form
 *
 * @package Rover\Fadmin\Admin
 * @author  Pavel Shulaev (http://rover-it.me)
 */
class Form
{
	/**
	 * @var string
	 */
	protected $moduleId;

	/**
	 * @var Options
	 */
	protected $options;

	/**
	 * @var \CAdminTabControl
	 */
	protected $tabControl;

	/**
	 * @var null|string
	 */
	protected $name;

	/**
	 * @param \CAdminTabControl $tabControl
	 * @param Options           $options
	 * @param null              $name
	 */
	public function __construct(\CAdminTabControl $tabControl, Options $options, $name = null)
	{
		$this->tabControl   = $tabControl;
		$this->options      = $options;
		$this->moduleId     = htmlspecialcharsbx($this->options->getModuleId());
		$this->name         = $name ?: $this->moduleId;
	}

	/**
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	public function show()
	{
		// showing tabs
		$tabs = $this->options->tabMap->getTabs(true);

		if (!count($tabs))
			return;

		$this->tabControl->Begin();
		$this->showFormBegin();

		foreach ($tabs as $tab)
			$this->showTab($tab);

		if ($this->options->settings->getGroupRights())
		    $this->showGroupRightsTab();

		$this->tabControl->EndTab();

		$this->showFormEnd();
	}

	/**
	 * @param Tab $tab
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	protected function showTab(Tab $tab)
	{
		// action afterRemovePreset
		if(false === $this->options->runEvent(
			Options::EVENT__BEFORE_SHOW_TAB,
			compact('tab')))
			return;

		$this->tabControl->BeginNextTab();
		$tab->show();
	}

    /**
     * @author Pavel Shulaev (https://rover-it.me)
     */
	protected function showGroupRightsTab()
    {

        global $APPLICATION, $REQUEST_METHOD;

        $RIGHTS     = $_REQUEST['RIGHTS'];
        $SITES      = $_REQUEST['SITES'];
        $GROUPS     = $_REQUEST['GROUPS'];
        $Apply      = $_REQUEST['Apply'];
        $Update     = $_REQUEST['Update'] ?:$Apply;
        $module_id  = $_REQUEST['mid'];

        $this->tabControl->BeginNextTab();
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");
    }

	/**
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	protected function showFormBegin()
	{
		global $APPLICATION;
		?><form method="post" id="fadmin-form" enctype="multipart/form-data" name='<?php $this->moduleId?>' action="<?=$APPLICATION->GetCurPage()?>?mid=<?=urlencode($this->moduleId)?>&amp;lang=<?=LANGUAGE_ID?>"><?php
	}


	/**
	 * @author Pavel Shulaev (http://rover-it.me)
	 */
	protected function showFormEnd()
	{
		$request = Application::getInstance()
			->getContext()
			->getRequest();

		$backUrl = $request->get('back_url_settings');

		$this->tabControl->Buttons();
		?><input
			type="submit"
			name="Update"
			value="<?=Loc::getMessage("MAIN_SAVE")?>"
			title="<?=Loc::getMessage("MAIN_OPT_SAVE_TITLE")?>"
			class="adm-btn-save">
		<input
			type="submit"
			name="Apply"
			value="<?=Loc::getMessage("MAIN_OPT_APPLY")?>"
			title="<?=Loc::getMessage("MAIN_OPT_APPLY_TITLE")?>">
		<?php if(strlen($backUrl) > 0):?>
			<input
				type="button"
				name="Cancel"
				value="<?=Loc::getMessage("MAIN_OPT_CANCEL")?>"
				title="<?=Loc::getMessage("MAIN_OPT_CANCEL_TITLE")?>"
				onclick="window.location='<?=htmlspecialcharsbx(\CUtil::addslashes($backUrl))?>'">
			<input
				type="hidden"
				name="back_url_settings"
				value="<?=htmlspecialcharsbx($backUrl)?>">
		<?php endif?>
		<input
			type="submit"
			name="RestoreDefaults"
			title="<?=Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS")?>"
			OnClick="return confirm('<?=AddSlashes(Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>')"
			value="<?=Loc::getMessage("MAIN_RESTORE_DEFAULTS")?>">
		<?=bitrix_sessid_post();?>
		<?php $this->tabControl->End();?>
	</form><?php
	}
}