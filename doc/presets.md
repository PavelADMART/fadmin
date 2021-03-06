# Работа с пресетами
Для создания пресета необходимо указать параметры его вкладки в конфигурации. В параметрах вкладки ключ `'preset'` должен быть равен `true`. 

Рассмотрим пример конфигурации кладки пресета из демо-класса для сайта `s1`:

	'tabs' => 
		...
		[
			'name'          => 'presetTab',
			'label'         => 'Preset',
			'preset'        => true,
			'description'   => 'This is a description of preset tab',
			'siteId'        => 's1',
			'inputs'        => [
			[
				'type'      => Input::TYPE__HEADER,
				'name'      => 'preset_header',
				'label'     => 'Preset header',
			],
			[
				'type'      => Input::TYPE__COLOR,
				'name'      => 'preset_color',
				'label'     => 'preset color',
				'default'   => '#FFAA00',
				'help'      => 'color help',
			],
			[
				'type'      => Input::TYPE__REMOVE_PRESET,
				'name'      => 'remove_preset',
				'label'     => 'remove_preset',
				'popup'     => 'Are you sure?',
			],
		],
	...
Особенности работы с вкладкой пресета:
* Для возможности удаления пресета на его вкладке необходимо разместить и настроить элемент типа `Input::TYPE__REMOVE_PRESET`. 
* Для возможности создавать пресет на обычной вкладке необходимо разместить и настроить элемент типа `Input::TYPE__ADD_PRESET`.
* Для каждого сайта может быть использована только одна конфигурация вкладки пресета. Если конфигураций несколько, то все последующие, кроме первой, будут игнорироваться. 
* При создании пресета будет браться конфигурация для того сайта, на вкладке которого была нажата кнопка `Input::TYPE__ADD_PRESET`.
* Пока для сайта не создан ни один пресет, шаблон его вкладки в настройках отображен не будет.
