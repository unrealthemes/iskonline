// Default SortableJS
import Sortable from 'sortablejs';
import inputManager, {inputTypes, renderInput as rInp} from './inputManager';

const urls = {
    steps: {
        get: `https://иск.онлайн/админ/формы/шаги/получение`,
        link: `https://иск.онлайн/админ/формы/шаги/привязка/`,
        delete: `https://иск.онлайн/админ/формы/шаги/удаление/`,
        move: `https://иск.онлайн/админ/формы/шаги/перемещение/`,
        clone: `https://иск.онлайн/админ/формы/шаги/копирование/`
    },

    groups: {
        delete: `https://иск.онлайн/админ/формы/группы/удаление/`,
        get: `https://иск.онлайн/админ/формы/группы/получение/`,
        link: `https://иск.онлайн/админ/формы/группы/привязка/`,
        clone: `https://иск.онлайн/админ/формы/группы/копирование/`,
    },

    inputs: {
        delete: `https://иск.онлайн/админ/формы/поля/удаление/`,
        get: `https://иск.онлайн/админ/формы/поля/получение/`,
        link: `https://иск.онлайн/админ/формы/поля/привязка/`,
        clone: `https://иск.онлайн/админ/формы/поля/копирование/`,
    },

    elements: {
        move: `https://иск.онлайн/админ/формы/элементы/перемещение/`,
    }
}

class FormConstructor {
    constructor (el) {
        // Основной элемент
        this.el = el;

        // Получение id формы
        this.formId = this.el.dataset.formId;
        this.formQuery = this.el.dataset.query;

        // Получение рабочей области
        this.area = $('.area', this.el);

        // Получение модальных окон
        this.modals = {
            addStep: $('#addStepModal', this.el),
            editStep: $('#editStepModal', this.el),
            addGroup: $('#addGroupModal', this.el),
            editGroup: $('#editGroupModal', this.el),
            addInput: $('#addInputModal', this.el),
            editInput: $('#editInputModal', this.el),
            editInputEvents: $('#editInputEventsModal', this.el),
        };
        
        this.handleStepsTable();
        this.handleGroupsTable();
        this.handleInputsTable();

        this.handleModalForms();
        this.handleInputModals();

        // JSON формы
        this.getForm();
    }

    getForm(callback = _ => {}) {
        fetch(this.formQuery).then(r => r.json()).then(r => {
            this.jsonAdapter = new FormJson(r.form);
            this.render();
            callback();
        });
    }

    postForm(form, callback, prehandle=_=>{}) {
        // Вешаем отправку формы фечем при сабмите
        form.onsubmit = ev => {
            ev.preventDefault();

            prehandle(form);

            let fd = new FormData(form);
            $$('input[type="checkbox"]', form).forEach(el =>
                fd.set(el.name, +el.checked)
            );

            fetch(form.action, {
                method: "POST",
                body: fd
            }).then(r => r.json()).then(r => {
                callback(r);
                
            });
        }
    }

    handleInputModals () {
        let modals = ['addInput', 'editInput'];

        modals.forEach(key => {
            inputManager($('.input-options-area', this.modals[key]), "string");

            let select = $(`[name="type"]`, this.modals[key]);
            select.innerHTML = "";

            for (let key in inputTypes) {
                select.insertAdjacentHTML('beforeend', `<option value="${key}">${inputTypes[key]}</option>`);
            }

            select.onchange = ev => {
                inputManager($('.input-options-area', this.modals[key]), ev.target.value);
            }
            
        });
        
    }

    handleModalForms() {
        // Получение формы в модалке
        for (let key in this.modals) {
            let form = $('form', this.modals[key]);
            
            if (form) {
                this.postForm(form, r => {
                    this.getForm();
                });
            }
        }
    }

    handleStepsTable() {
        // Обновление шагов по нажатию на кнопку открытия модалки добавления шагов
        $(`[data-bs-target="#${this.modals.addStep.id}"]`, this.el).onclick = () => {
            // Очистка таблицы
            $("#savedStepsTable", this.modals.addStep).innerHTML = ``;

            // Получение данных
            fetch(urls.steps.get).then(r => r.json()).then(r => {
                r.forEach(step => {
                    // Добавление строк в таблицу
                    let html = `
                        <tr>
                            <td><small>#${step.id}</small> <b>${step.title}</b></td>
                            <td>
                                <button class="btn btn-primary btn-small" role="submit" data-use data-saved-step-id="${step.id}">Использовать</button>
                                <button class="btn btn-warning btn-small" role="submit" data-clone data-saved-step-id="${step.id}">Копировать</button>
                            </td>
                        </tr>
                    `;

                    $("#savedStepsTable", this.modals.addStep).insertAdjacentHTML(`beforeend`, html);
                });
                
                // Пробегаем по кнопкам "Использовать"
                $$('[data-use]', this.modals.addStep).forEach(el => {
                    el.onclick = ev => {
                        let stepId = el.dataset.savedStepId;

                        fetch(`${urls.steps.link}${this.formId}/${stepId}`).then(r => r.json()).then(r => {
                            this.getForm();

                            success2("Шаг успешно привязан!");
                        });
                    }
                });

                // Пробегаем по кнопкам "Копировать"
                $$('[data-clone]', this.modals.addStep).forEach(el => {
                    el.onclick = ev => {
                        let stepId = el.dataset.savedStepId;

                        fetch(`${urls.steps.clone}${this.formId}/${stepId}`).then(r => r.json()).then(r => {
                            this.getForm();

                            success2("Шаг успешно скопирован!");
                        });
                    }
                });
            });
        }
    }

    handleGroupsTable() {
        // Обновление групп по нажатию на кнопку открытия модалки добавления группы
        $(`#savedGroupTab`, this.el).onclick = () => {
            // Очистка таблицы
            $("#savedGroupsTable", this.modals.addGroup).innerHTML = ``;

            // Получение данных
            fetch(urls.groups.get).then(r => r.json()).then(r => {
                r.forEach(group => {
                    // Добавление строк в таблицу
                    let html = `
                        <tr>
                            <td><small>#${group.id}</small> <b>${group.title}</b></td>
                            <td>
                                <span class="btn btn-primary btn-small" role="submit" data-use data-saved-group-id="${group.id}">Использовать</span>
                                <span class="btn btn-warning btn-small" role="submit" data-clone data-saved-group-id="${group.id}">Копировать</span>
                            </td>
                        </tr>
                    `;

                    $("#savedGroupsTable", this.modals.addGroup).insertAdjacentHTML(`beforeend`, html);
                });
                
                // Пробегаем по кнопкам "Использовать"
                $$('[data-use]', this.modals.addGroup).forEach(el => {
                    el.onclick = ev => {
                        let fd = new FormData($('form', this.modals.addGroup));

                        fetch(`${urls.groups.link}${el.dataset.savedGroupId}`, {
                            method: "POST",
                            body: fd,
                        }).then(r => r.json()).then(r => {
                            this.getForm();

                            success2("Группа успешно привязана!");
                        });
                    }
                });

                // Пробегаем по кнопкам "Копировать"
                $$('[data-clone]', this.modals.addGroup).forEach(el => {
                
                    el.onclick = ev => {
                        let fd = new FormData($('form', this.modals.addGroup));

                        fetch(`${urls.groups.clone}${el.dataset.savedGroupId}`, {
                            method: "POST",
                            body: fd,
                        }).then(r => r.json()).then(r => {
                            this.getForm();

                            success2("Группа успешно скопирована!");
                        });
                    }
                });
            });
        };
    }

    handleInputsTable() {
        // Обновление групп по нажатию на кнопку открытия модалки добавления группы
        $(`#savedInputTab`, this.el).onclick = () => {
            // Очистка таблицы
            $("#savedInputsTable", this.modals.addInput).innerHTML = ``;

            // Получение данных
            fetch(urls.inputs.get).then(r => r.json()).then(r => {
                r.forEach(input => {
                    // Добавление строк в таблицу
                    let html = `
                        <tr>
                            <td><small>#${input.id}</small> <b>${input.label}</b></td>
                            <td>
                                <span class="btn btn-primary btn-small" role="submit" data-use data-saved-input-id="${input.id}">Использовать</span>
                                <span class="btn btn-warning btn-small" role="submit" data-clone data-saved-input-id="${input.id}">Копировать</span>
                            </td>
                        </tr>
                    `;

                    $("#savedInputsTable", this.modals.addInput).insertAdjacentHTML(`beforeend`, html);
                });

                // Пробегаем по кнопкам "Использовать"
                $$('[data-use]', this.modals.addInput).forEach(el => {
                    el.onclick = ev => {
                        let fd = new FormData($('form', this.modals.addInput));

                        fetch(`${urls.inputs.link}${el.dataset.savedInputId}`, {
                            method: "POST",
                            body: fd,
                        }).then(r => r.json()).then(r => {
                            this.getForm();

                            success2("Группа успешно привязана!");
                        });
                    }
                });

                // Пробегаем по кнопкам "Копировать"
                $$('[data-clone]', this.modals.addInput).forEach(el => {
                
                    el.onclick = ev => {
                        let fd = new FormData($('form', this.modals.addInput));

                        fetch(`${urls.inputs.clone}${el.dataset.savedInputId}`, {
                            method: "POST",
                            body: fd,
                        }).then(r => r.json()).then(r => {
                            this.getForm();

                            success2("Группа успешно скопирована!");
                        });
                    }
                });
            });
        };
    }


    render() {

        let steps = this.jsonAdapter.getSteps();
        Array.from(this.area.children).forEach(ch => ch.remove());

        steps.forEach((step, i) => {
            // Отрисовка шага
            this.renderStep(step, i);
            
        });

        new Sortable(this.area, {
            animation: 150,
            handle: '.step-move',
            onEnd: ev => {
                let stepsOrder = [];
                $$('.step-el').forEach(step => {
                    stepsOrder.push(step.dataset.formStepId);
                });

                stepsOrder = JSON.stringify(stepsOrder);

                let fd = new FormData();
                fd.append('order', stepsOrder);
                fetch(`${urls.steps.move}${this.formId}`, {
                    method: "POST",
                    body: fd
                }).then(r => r.json()).then(r => {
                    
                });
            }
        });
    }

    renderStep(step, i) {
        let html = `
            <li class="col-12 mt-3 mb-4 step-el" data-step="${step.id}" id="step${i}" data-form-step-id="${step.form_step_id}">
                <div class="bg-white block position-relative pb-5">
                    <h3 class="d-flex justify-content-between">
                    <div>
                        <span class="text-primary step-edit" role="button" data-bs-toggle="modal" data-bs-target="#${this.modals.editStep.id}">
                            <i style="width: 15px;" class="fa-solid fa-pen"></i>
                        </span> 
                        ${step.title}
                    </div>
                    <span class="text-danger step-remove" role="button" data-form-step-id="${step.form_step_id}">
                        <i class="fa-solid fa-trash"></i>
                    </span> 
                    </h3>

                    <ul class="row" data-area data-step-area="${step.id}" data-parent-table="form_ui_steps" data-parent-id="${step.id}">

                    </ul>

                    <div style="position: absolute; bottom: -20px; left: 20px;" class="d-flex gap-3">
                        <div data-bs-toggle="tooltip" data-bs-title="Добавить содержимое" data-bs-html='true' data-bs-trigger='hover' data-bs-placement="left"><a 
                            role="button"
                            class="not-focus bg-secondary text-white rounded-circle step-add-element" 
                            data-toggle="collapse" href="#actionCollapse${i}"
                            style="display: grid; place-items: center; width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-plus"></i>
                        </a></div>
                        <div class="collapse collapse custom-collapse" id="actionCollapse${i}">
                            <div class="d-flex gap-3" style="width: 152px;">
                                <div class='tool' data-bs-toggle="tooltip" data-bs-title="Добавить поле ввода" data-bs-html='true' data-bs-trigger='hover'><div 
                                    role="button"
                                    class="bg-primary text-white rounded-circle add-element add-input" 
                                    data-bs-toggle="modal" data-bs-target="#${this.modals.addInput.id}"
                                    style="display: grid; place-items: center; width: 40px; height: 40px;"
                                >
                                    <i class="fa-solid fa-mattress-pillow"></i>
                                </div></div>
                                <div class='tool' data-bs-toggle="tooltip" data-bs-title="Добавить группу" data-bs-html='true' data-bs-trigger='hover'><div 
                                    role="button"
                                    class="bg-primary text-white rounded-circle add-element add-group" 
                                    data-bs-toggle="modal" data-bs-target="#${this.modals.addGroup.id}"
                                    style="display: grid; place-items: center; width: 40px; height: 40px;"
                                >
                                    <i class="fa-solid fa-object-group"></i>
                                </div></div>
                                
                            </div>
                            
                        </div>
                    </div>
                    

                    <div 
                        role="button"
                        class="text-primary rounded-circle step-move" 
                        style="position: absolute; top: calc(50% - 20px); right: calc(100% - 5px); display: grid; place-items: center; width: 40px; height: 40px;"
                    >
                        <i class="fa-solid fa-grip-vertical"></i>
                    </div>
                </div>
            </li>
        `;

        this.area.insertAdjacentHTML('beforeend', html);

        // Получение внутреннего поля шага
        let stepArea = $(`#step${i} [data-step-area]`, this.el);

        // РАБОТА С ШАГАМИ
        // Подвешивание модалки на кнопку изменения
        $(`#step${i} .step-edit`, this.el).onclick = ev => {
            $("#editingStepId", this.el).value = step.id;
            $('[name="title"]', this.modals.editStep).value = step.title;
            $('[name="prefix"]', this.modals.editStep).value = step.prefix;
            
            $('[name="show_in_saved"]', this.modals.editStep).checked = step.show_in_saved;
        }

        // Подвешивание удаления
        $(`#step${i} .step-remove`, this.el).onclick = ev => {
            let btn = $(`#step${i} .step-remove`, this.el);
            confirm2(() => {
                fetch(`${urls.steps.delete}${btn.dataset.formStepId}`).then(r => r.json()).then(r => {
                    this.getForm();
                });
            });
        }

        // РАБОТА С ЭЛЕМЕНТАМИ
        // Подвешивание модалки добавления элемента, заполнение в форме полей parentTable и parentId
        $$(`#step${i} .add-element`, this.el).forEach(el => {
            el.onclick = () => {
                this.fillAddElementParams(stepArea, el.classList.contains('add-group') ? "addGroup" : "addInput");
            }
        });

        // РАБОТА С ДОЧЕРНИМИ ЭЛЕМЕНТАМИ
        // Отрисовка дочерних элементов
        this.renderChildren(step.elements, stepArea);
    }

    fillAddElementParams(area, modal="addGroup") {
        $(`[name="element-parent_table"]`, this.modals[modal]).value = area.dataset.parentTable;
        $(`[name="element-parent_id"]`, this.modals[modal]).value = area.dataset.parentId;
    }

    renderChildren(elements, area) {
        Array.from(area.children).forEach(ch => ch.remove());

        elements.forEach((element, i) => {
            // Отрисовка элемента
            this.renderElement(element, Math.trunc(Math.random() * 10000), area);
            
        });

        // Подключение сортировки внутри шага
        new Sortable(area, {
            group: 'nested',
            fallbackOnBody: true,
            animation: 150,
            onEnd: ev => {
                let order = this.parseElements();

                let fd = new FormData();
                fd.append('order', JSON.stringify(order));

                fetch(`${urls.elements.move}`, {
                    body: fd,
                    method: "POST"
                }).then(r => r.json()).then(r => {
                    this.getForm();
                });
            }
        });
    }

    renderElement(element, i, area) {
        let childArea = null;
        switch (element.type) {
            case "group":
                childArea = this.renderGroup(element, i, area);
                break;

            case "input":
                this.renderInput(element, i, area);
                break;
        }

        if (childArea) {
            this.renderChildren(element.elements, childArea);
        }
    }

    renderInput(input, i, area) {
        let html = `
            <li class="col-${input.column} mt-2 d-flex align-items-center input-element gap-1" id="element${i}" data-element-id="${input.element_id}">
                <i role="button" style="width: 7px;" class="fa-solid fa-grip-vertical text-primary"></i>
            </li>
        `;

        area.insertAdjacentHTML('beforeend', html);

        // Элемент
        let li = $(`#element${i}`, area);

        // Получение инпута и добавление в элемент
        let inputEl = rInp(input, "", [], input.name);

        // Скрытый элемент
        if (input.options.hidden == 1) {
            inputEl.style.opacity = 0.8;
        }

        li.appendChild(inputEl);

        // РАБОТА С ДЕЙСТВИЯМИ
        context([li],
            [
                // Редактирование инпута
                {
                    title: `<span data-bs-toggle="modal" style="height: 100%; width: 100%;" data-bs-target="#${this.modals.editInput.id}">
                                <i style="width: 30px;" class="fa-solid fa-pen"></i> 
                                Редактировать
                            </span>`,
                    action: _ => {
                        // Заполнение формы
                        $(`form`, this.modals.editInput).reset();

                        $(`[name="name"]`, this.modals.editInput).value = input.name;
                        $(`[name="label"]`, this.modals.editInput).value = input.label;
                        $(`[name="type"]`, this.modals.editInput).value = input.input_type;

                        $(`[name="elementId"]`, this.modals.editInput).value = input.element_id;
                        $(`[name="element-column"]`, this.modals.editInput).value = input.column;
                        $(`[name="element-name"]`, this.modals.editInput).value = input.element_name;

                        $(`[name="show_in_saved"]`, this.modals.editInput).checked = +input.show_in_saved;
                        $(`[name="options-required"]`, this.modals.editInput).checked = +input.options.required;
                        $(`[name="options-hidden"]`, this.modals.editInput).checked = +input.options.hidden;

                        inputManager($('.input-options-area', this.modals.editInput), input.input_type, input.options);
                    }
                },

                // Редактирование событий
                {
                    title: `<span data-bs-toggle="modal" style="height: 100%; width: 100%;" data-bs-target="#${this.modals.editInputEvents.id}">
                                <i style="width: 30px;" class="fa-solid fa-play"></i> 
                                Сценарии поля
                            </span>`,
                    action: _ => {
                        // Заполнение формы
                        let constructor = new LogicConstructor($('.events', this.modals.editInputEvents), this.jsonAdapter, input);

                        $('[name="input"]', this.modals.editInputEvents).value = input.id;

                        this.postForm($('form', this.modals.editInputEvents), () => {
                            success2("Сценарии успешно сохранены");
                            this.getForm();

                        }, form => {
                            $('[name="events"]', this.modals.editInputEvents).value = JSON.stringify(constructor.parseLogic());
                        });
                    }
                },

                // Удаление инпута
                {
                    title: `<span>
                                <i style="width: 30px;" class="fa-solid fa-trash"></i> 
                                Удалить
                            </span>`,
                    action: _ => {
                        confirm2(() => {
                            fetch(`${urls.inputs.delete}${input.element_id}`).then(r => r.json()).then(r => {
                                this.getForm();
                            });
                        });
                        
                    }
                },
            ]
        );
    }

    renderGroup(group, i, area) {
        let html = `
            <li class="col-${group.column} mt-3" id="element${i}" data-element-id="${group.element_id}">
                <div class="fieldset rounded border p-3">
                    <div class='legend px-2 text-muted' role="button">
                        ${group.name} 
                    </div>
                    <ul class="row py-1" data-area data-group-area="${group.id}" data-parent-table="form_ui_groups" data-parent-id="${group.id}">
                        
                    </ul>
                    ${group.description ? `<p>${group.description}</p>` : ``}
                </div>
            </li>
        `;

        area.insertAdjacentHTML('beforeend', html);

        let groupArea = $(`#element${i} [data-area]`, area);

        // РАБОТА С ДЕЙСТВИЯМИ
        context($$(`#element${i} .legend`, area),
            [
                // Редактирование группы
                {
                    title: `<span data-bs-toggle="modal" style="height: 100%; width: 100%;" data-bs-target="#${this.modals.editGroup.id}">
                                <i style="width: 30px;" class="fa-solid fa-pen"></i> 
                                Редактировать
                            </span>`,
                    action: _ => {
                        $(`form`, this.modals.editGroup).reset();
                        // Заполнение формы
                        $(`[name="elementId"]`, this.modals.editGroup).value = group.element_id;
                        $(`[name="element-column"]`, this.modals.editGroup).value = group.column;
                        $(`[name="element-name"]`, this.modals.editGroup).value = group.element_name;
                        $(`[name="name"]`, this.modals.editGroup).value = group.name;
                        $(`[name="prefix"]`, this.modals.editGroup).value = group.prefix;
                        $(`[name="description"]`, this.modals.editGroup).innerText = group.description;
                        $(`[name="options-show_name"]`, this.modals.editGroup).checked = +group.options.show_name;
                        $(`[name="options-border"]`, this.modals.editGroup).checked = +group.options.border;
                        $(`[name="options-hidden"]`, this.modals.editGroup).checked = +group.options.hidden;
                        $(`[name="clonable"]`, this.modals.editGroup).checked = +group.clonable;
                        $(`[name="show_in_saved"]`, this.modals.editGroup).checked = +group.show_in_saved;
                    }
                },

                // Удаление группы
                {
                    title: `<span>
                                <i style="width: 30px;" class="fa-solid fa-trash"></i> 
                                Удалить группу
                            </span>`,
                    action: _ => {
                        confirm2(() => {
                            fetch(`${urls.groups.delete}${group.element_id}`).then(r => r.json()).then(r => {
                                this.getForm();
                            });
                        });
                        
                    }
                },

                // Добавление дочерней группы 
                {
                    title: `<span data-bs-toggle="modal" data-bs-target="#${this.modals.addGroup.id}">
                                <i style="width: 30px;" class="fa-solid fa-object-group"></i> 
                                Добавить группу
                            </span>`,
                    action: _ => {
                        this.fillAddElementParams(groupArea);
                    }
                },

                // Добавление поля вводя
                {
                    title: `<span data-bs-toggle="modal" data-bs-target="#${this.modals.addInput.id}">
                                <i style="width: 30px;" class="fa-solid fa-mattress-pillow"></i>
                                Добавить поле ввода
                            </span>`,
                    action: _ => {
                        this.fillAddElementParams(groupArea, "addInput");
                    }
                }
            ]
        );

        return groupArea;
    }

    // Парсинг структуры формы
    parseElements() {
        let lis = $$('li[data-element-id]');
        let order = [];
        lis.forEach(el => {
            let parent = el.parentNode;
            
            order.push([el.dataset.elementId, parent.dataset.parentTable, parent.dataset.parentId]);
        });

        return order;
    }
}

const context = (els, items) => {

    els.forEach(el => {
        el.oncontextmenu = (ev) => {
            ev.preventDefault();
            let lis = "";

            items.forEach((item, i) => {
                lis += `<li data-context-item="${i}" role="button" class="list-group-item">${item.title}</li>`;
            });

            let html = `
                <div class="card context-menu" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        ${lis}
                    </ul>
                </div>
            `;

            let menu = document.createElement('div');
            menu.innerHTML = html;
            menu.style.position = `absolute`;
            menu.style.left = `${ev.pageX - 10}px`;
            menu.style.top = `${ev.pageY - 10}px`;

            document.body.appendChild(menu);

            menu.onmouseleave = () => {
                menu.remove();
            }

            function clickInsideElement( e, className ) {
                var el = e.srcElement || e.target;
               
                if ( el.classList.contains(className) ) {
                  return el;
                } else {
                  while ( el = el.parentNode ) {
                    if ( el.classList && el.classList.contains(className) ) {
                      return el;
                    }
                  }
                }
               
                return false;
              }

            document.addEventListener( "click", function(e) {
                var clickeElIsLink = clickInsideElement( e, "context-menu" );
             
                if ( clickeElIsLink ) {
                  e.preventDefault();
                  
                } else {
                  var button = e.which || e.button;
                  if ( button === 1 ) {
                    menu.remove();
                  }
                }
              });
            
            items.forEach((item, i) => {
                let li = $(`li[data-context-item="${i}"]`);
                
                li.addEventListener('click', _ => {
                    item.action();
                });
            });
        }
    });
    
}

import { $, $$ } from "../funcs";
import FormJson from "../formJsonAdapter";
import {confirm2, success2} from "./alerts";
import LogicConstructor from './logicConstructor';

export default FormConstructor;