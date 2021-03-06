# Описание класса `\Rover\Fadmin\Options\Event`
Класс предназначен для генерации и обраотки событий.

* [Константы](#Константы)
* [Методы](#Методы)

## Константы
Константы содержат типы событий, которые генерируются в процессе работы модуля, использующего «Конструктор». События могут быть обработаны в пользовательских модулях, подробнее [здесь](../events.md).

### `BEFORE_GET_REQUEST = 'beforeGetRequest'`
Вызывается перед обработкой реквеста. Не принимает параметров. Если возвращает `false`, то реквест не обрабатывается.
### `BEFORE_REDIRECT_AFTER_REQUEST = 'beforeRedirectAfterRequest'`
Вызывается перед редиректом после реквеста. Принимает и позволяет менять параметры:
* `url` — адрес для редиректа. 

Если возвращает `false`, редирект не производится.
### `BEFORE_ADD_VALUES_FROM_REQUEST = 'beforeAddValuesFromRequest'`
Вызывается перед сохранением данных из реквеста. Не принимает параметров. Если возвращает `false`, данные не сохраняются.
### `BEFORE_ADD_VALUES_TO_TAB_FROM_REQUEST = 'beforeAddValuesToTabFromRequest'`
Вызывается перед добавлением данных из реквеста в каждый таб. Принимает и позволяет менять параметры:
* `tab` — объект `\Rover\Fadmin\Tab` таба, в котором предстоит обновить значения инпутов.

Если возвращает `false`, данные в таб не сохраняются.
### `AFTER_ADD_VALUES_FROM_REQUEST = 'afterAddValuesFromRequest'`
Ввызывается после сохранения данных из реквеста. Принимает и позволяет менять параметры:
* `tabs` — массив объектов `\Rover\Fadmin\Tab` табов, в которых были обновлены значения инпутов.

Если возвращает `false`, редирект не производится.
### `BEFORE_ADD_PRESET = 'beforeAddPreset'`
Вызывается перед добавлением нового пресета. Принимает и позволяет менять параметры:
* `siteId` — id сайта, для которого добавляется пресет;
* `value` — имя пресета, полученное из реквета.

Если вы хотите задать другое имя пресета, то верните его в ключе `name`. Если возвращает `false`, то пресет не добавляется.
### `AFTER_ADD_PRESET = 'afterAddPreset'`
Вызывается после добавления нового пресета. Принимает и позволяет менять параметры:
* `siteId` — id сайта, для которого добавляется пресет;
* `value` — имя пресета, полученное из реквета;
* `name`  — итоговое имя, которое могло быть задано в `BEFORE_ADD_PRESET` либо сгенерировано автоматически;   
* `id`    — id пресета.

### `BEFORE_REMOVE_PRESET = 'beforeRemovePreset'`
Вызывается перед удалением пресета. Принимает и позволяет менять параметры:                                	
* `siteId` — id сайта, для которого удаляется пресет;
* `id` — id удаляемого пресета.
    
Если возвращает `false`, то пресет не удаляется. 
### `AFTER_REMOVE_PRESET    = 'afterRemovePreset'`
Вызывается после удаления пресета. Принимает и позволяет менять параметры:                                	
* `siteId` — id сайта, для которого был удалён;
* `id` — id удаленного пресета.
### `BEFORE_MAKE_PRESET_TAB = 'beforeMakePresetTab'`
Вызывается перед созданием таба пресета. Принимает и позволяет менять параметры:
* `tabParams` — массив параметров создаваемого таба-пресета, получаемый из метода `Options::getConfig()`;
* `presetId` — id пресета; 
* `presetName` — имя пресета. 

Если возвращает `false`, то таб не создается.  
### `AFTER_MAKE_PRESET_TAB = 'afterMakePresetTab'`
Вызывается после создания таба пресета. Принимает и позволяет менять параметры:
* `tab` — объект `\Rover\Fadmin\Tab` данного пресета.
### `BEFORE_SHOW_TAB = 'beforeShowTab'`
Вызывается перед отрисовкой таба. Принимает и позволяет менять параметры:
* `tab` — объект `\Rover\Fadmin\Tab` выводимого таба. Если возвращает `false`, то таб не отображается.  
### `AFTER_GET_TABS = 'afterGetTabs'`
Вызывается после получения массива всех существующих табов.  Принимает и позволяет менять параметры:
* `tabs` — массив объектов `\Rover\Fadmin\Tab` существующих табов.  
### `BEFORE_GET_TAB_INFO = 'beforeGetTabInfo'`
Вызывается перед заданием параметров для каждого таба. Принимает и позволяет менять параметры:
* `name` — имя таба в системе;
* `label` — название вкладки таба;
* `icon` — иконка таба;
* `description` — описание таба.

## Поля
Раздел находится в разработке

## Методы
Раздел находится в разработке
