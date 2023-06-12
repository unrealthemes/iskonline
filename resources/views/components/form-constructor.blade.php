<div class="form-constructor" data-query="{{ route('admin.forms.forms.getJson', ['form' => $formId]) }}" data-form-id="{{ $formId }}">

    <ul class="row area pl">

    </ul>

    <div class="mt-3">
        <x-modals.modal-button id="addStepModal">
            <div class="w-100 text-center text-primary border border-primary rounded-lg p-4 fs-6 block">Добавить шаг</div>
        </x-modals.modal-button>
    </div>


    <x-modals.modal id="addStepModal" title="Добавление шага">
        <x-tabs.tabs>
            <x-tabs.tabs-button tab-id="newStepTab" content-id="newStepContent" active="true">Новый шаг</x-tabs.tabs-button>
            <x-tabs.tabs-button tab-id="savedStepTab" content-id="savedStepContent">Выбрать существующий</x-tabs.tabs-button>
        </x-tabs.tabs>
        <x-tabs.tabs-content>
            <x-tabs.tabs-pane tab-id="newStepTab" content-id="newStepContent" active="true">
                <x-form.form action="{{ route('admin.forms.steps.store', ['form' => $formId]) }}">
                    <x-form.input name="title" label="Заголовок" form-floating="true" required="true"></x-form.input>
                    <x-form.input name="prefix" label="Префикс" form-floating="true"></x-form.input>
                    <x-form.checkbox name="show_in_saved" label="Показывать в существующих" value="1"></x-form.checkbox>
                    <x-form.btn class="mt-3">Добавить</x-form.btn>
                </x-form.form>
            </x-tabs.tabs-pane>
            <x-tabs.tabs-pane tab-id="savedStepTab" content-id="savedStepContent">
                <div class="p-3">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Шаг</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="savedStepsTable">
                        </tbody>
                    </table>
                </div>
            </x-tabs.tabs-pane>
        </x-tabs.tabs-content>
    </x-modals.modal>

    <x-modals.modal id="editStepModal" title="Изменение шага">
        <x-form.form action="{{ route('admin.forms.steps.update', ['form' => $formId]) }}">
            <input type="hidden" name="stepId" id="editingStepId">
            <x-form.input name="title" label="Заголовок" form-floating="true" required="true"></x-form.input>
            <x-form.input name="prefix" label="Префикс" form-floating="true"></x-form.input>
            <x-form.checkbox name="show_in_saved" label="Показывать в существующих" value="1"></x-form.checkbox>
            <x-form.btn class="mt-3">Сохранить</x-form.btn>
        </x-form.form>
    </x-modals.modal>

    <x-modals.modal id="addGroupModal" title="Добавление группы">
        <x-form.form action="{{ route('admin.forms.groups.store', ['form' => $formId]) }}">
            <x-form-constructor.inserting-element parents="true"></x-form-constructor.inserting-element>
            <p class="mt-4 mb-2"><b>Данные элемента</b></p>
            <x-tabs.tabs>
                <x-tabs.tabs-button tab-id="newGroupTab" content-id="newGroupContent" active="true">Новая группа</x-tabs.tabs-button>
                <x-tabs.tabs-button tab-id="savedGroupTab" content-id="savedGroupContent">Выбрать существующую</x-tabs.tabs-button>
            </x-tabs.tabs>
            <x-tabs.tabs-content>
                <x-tabs.tabs-pane tab-id="newGroupTab" content-id="newGroupContent" active="true">
                    <div class="row">
                        <div class="col-6 mt-3">
                            <x-form.input name="name" label="Имя группы" form-floating="true"></x-form.input>
                        </div>
                        <div class="col-6 mt-3">
                            <x-form.input name="prefix" label="Префикс" form-floating="true"></x-form.input>
                        </div>
                        <div class="col-12 mt-3">
                            <x-form.input name="description" rows="4" type="textarea" label="Описание группы" form-floating="true"></x-form.input>
                            <x-form.checkbox name="options-show_name" label="Показывать имя группы в заголовке" value="1"></x-form.checkbox>
                            <x-form.checkbox name="options-border" label="Показываь границу группы" value="1"></x-form.checkbox>
                            <x-form.checkbox name="clonable" label="Дублируемая группа" value="1"></x-form.checkbox>
                            <x-form.checkbox name="show_in_saved" label="Показывать в существующих" value="1"></x-form.checkbox>
                            <x-form.checkbox name="options-hidden" label="Скрытый элемент"></x-form.checkbox>

                        </div>
                    </div>
                    <div class="mt-3">
                        <x-form.btn>Добавить</x-form.btn>
                    </div>
                </x-tabs.tabs-pane>
                <x-tabs.tabs-pane tab-id="savedGroupTab" content-id="savedGroupContent">
                    <div class="p-3">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Группа</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody id="savedGroupsTable">
                            </tbody>
                        </table>
                    </div>
                </x-tabs.tabs-pane>
            </x-tabs.tabs-content>
        </x-form.form>
    </x-modals.modal>

    <x-modals.modal id="editGroupModal" title="Изменение группы">
        <x-form.form action="{{ route('admin.forms.groups.update', ['form' => $formId]) }}">

            <x-form-constructor.inserting-element></x-form-constructor.inserting-element>
            <p class="mt-4 mb-2"><b>Данные элемента</b></p>
            <div class="row">
                <div class="col-6 mt-3">
                    <x-form.input name="name" label="Имя группы" form-floating="true"></x-form.input>
                </div>
                <div class="col-6 mt-3">
                    <x-form.input name="prefix" label="Префикс" form-floating="true"></x-form.input>
                </div>
                <div class="col-12 mt-3">
                    <x-form.input name="description" rows="4" type="textarea" label="Описание группы" form-floating="true"></x-form.input>
                    <x-form.checkbox name="options-show_name" label="Показывать имя группы в заголовке"></x-form.checkbox>
                    <x-form.checkbox name="options-border" label="Показываь границу группы"></x-form.checkbox>
                    <x-form.checkbox name="clonable" label="Дублируемая группа"></x-form.checkbox>
                    <x-form.checkbox name="show_in_saved" label="Показывать в существующих"></x-form.checkbox>
                    <x-form.checkbox name="options-hidden" label="Скрытый элемент"></x-form.checkbox>

                </div>
            </div>
            <div class="mt-3">
                <x-form.btn>Сохранить</x-form.btn>
            </div>
        </x-form.form>
    </x-modals.modal>

    <x-modals.modal id="addInputModal" title="Добавление поля ввода">

        <x-form.form action="{{ route('admin.forms.inputs.store', ['form' => $formId]) }}">

            <x-form-constructor.inserting-element parents="true"></x-form-constructor.inserting-element>
            <p class="mt-4 mb-2"><b>Данные элемента</b></p>
            <x-tabs.tabs>
                <x-tabs.tabs-button tab-id="newInputTab" content-id="newInputContent" active="true">Новое поле</x-tabs.tabs-button>
                <x-tabs.tabs-button tab-id="savedInputTab" content-id="savedInputContent">Выбрать существующее</x-tabs.tabs-button>
            </x-tabs.tabs>
            <x-tabs.tabs-content>
                <x-tabs.tabs-pane tab-id="newInputTab" content-id="newInputContent" active="true">
                    <div class="row">
                        <div class="col-4">
                            <x-form.input name="name" label="Имя поля" form-floating="true" required="true"></x-form.input>
                            <span class="text-muted">*Имя поля латиницей, маленькими буквами</span>
                        </div>
                        <div class="col-4">
                            <x-form.input name="label" label="Подпись поля" form-floating="true" required="true"></x-form.input>
                        </div>
                        <div class="col-4">
                            <x-form.input type="select" name="type" label="Тип поля" form-floating="true">
                                <option value="text">Строка</option>
                                <option value="textarea">Абзац</option>
                                <option value="number">Число</option>
                                <option value="date">Дата</option>
                                <option value="checkbox">Чекбокс</option>
                                <option value="radio">Радио-кнопка</option>
                            </x-form.input>
                        </div>
                        <div class="col-12 mt-3">
                            <x-form.input name="helper" label="Загрузка подсказки" type="file"></x-form.input>
                        </div>
                        <div class="col-12 mt-3">
                            <x-form.checkbox name="options-required" label="Обязательное поле" checked="true"></x-form.checkbox>
                            <x-form.checkbox name="show_in_saved" label="Показывать в существующих" checked="true"></x-form.checkbox>
                            <x-form.checkbox name="options-hidden" label="Скрытый элемент"></x-form.checkbox>
                        </div>
                        <div class="col-12 mt-4">
                            <b>Настройки поля</b>
                            <div class="input-options-area row">

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="events" value="[]">
                    <input type="hidden" name="validation" value="{}">
                    <div class="mt-3">
                        <x-form.btn>Добавить</x-form.btn>
                    </div>
                </x-tabs.tabs-pane>
                <x-tabs.tabs-pane tab-id="savedInputTab" content-id="savedInputContent">
                    <div class="p-3">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Поле</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody id="savedInputsTable">
                            </tbody>
                        </table>
                    </div>
                </x-tabs.tabs-pane>
            </x-tabs.tabs-content>
        </x-form.form>
    </x-modals.modal>

    <x-modals.modal id="editInputModal" title="Редактирование поля ввода">

        <x-form.form action="{{ route('admin.forms.inputs.update', ['form' => $formId]) }}">

            <x-form-constructor.inserting-element></x-form-constructor.inserting-element>
            <p class="mt-4 mb-2"><b>Данные элемента</b></p>
            <div class="row">
                <div class="col-4">
                    <x-form.input name="name" label="Имя поля" form-floating="true" required="true"></x-form.input>
                    <span class="text-muted">*Имя поля латиницей, маленькими буквами</span>
                </div>
                <div class="col-4">
                    <x-form.input name="label" label="Подпись поля" form-floating="true" required="true"></x-form.input>
                </div>
                <div class="col-4">
                    <x-form.input type="select" name="type" label="Тип поля" form-floating="true">
                        <option value="text">Строка</option>
                        <option value="textarea">Абзац</option>
                        <option value="number">Число</option>
                        <option value="date">Дата</option>
                        <option value="checkbox">Чекбокс</option>
                        <option value="radio">Радио-кнопка</option>
                    </x-form.input>
                </div>
                <div class="col-12 mt-3">
                    <x-form.input name="helper" label="Загрузка новой подсказки" type="file"></x-form.input>
                    <x-form.checkbox name="remove_helper" label="Убрать подсказку"></x-form.checkbox>
                </div>
                <div class="col-12 mt-3">
                    <x-form.checkbox name="options-required" label="Обязательное поле"></x-form.checkbox>
                    <x-form.checkbox name="options-hidden" label="Скрытый элемент"></x-form.checkbox>
                    <x-form.checkbox name="show_in_saved" label="Показывать в существующих"></x-form.checkbox>
                </div>
                <div class="col-12 mt-4">
                    <b>Настройки поля</b>
                    <div class="input-options-area row">

                    </div>
                </div>
            </div>
            <input type="hidden" name="validation" value="{}">
            <div class="mt-3">
                <x-form.btn>Сохранить</x-form.btn>
            </div>
        </x-form.form>
    </x-modals.modal>

    <x-modals.modal size='xl' id="editInputEventsModal" title="Управление сценариями поля">
        <div class="events row">
            <div class="col-8">
                <h6>Сценарии поля</h6>
            </div>
            <div class="col-4">
                <h6>Удаление блока</h6>
            </div>
            <div class="col-8" style="padding-top: 20px;">
                <ul class="logic-area" data-event="">

                </ul>
            </div>
            <div class="col-4">
                <ul class="blocks-trash rounded alert alert-danger py-3" style="border: 0px; display: grid; place-items: center;">
                    <i class="text-danger fa-solid fa-trash"></i>
                </ul>
                <h6>Блоки</h6>
                <ul class="blocks-area bg-light rounded p-3" style="max-height: 600px; overflow: auto;">

                </ul>
            </div>

        </div>
        <x-form.form action="{{ route('admin.forms.inputs.logic') }}">
            <input type="hidden" id="input" name="input">
            <input type="hidden" id="events" name="events">
            <x-form.btn>Сохранить</x-form.btn>
        </x-form.form>
    </x-modals.modal>
</div>