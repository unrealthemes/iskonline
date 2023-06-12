import inputManager, {getElementValue, getValue, inputTypes, renderInput as rInp, saveInputs} from "../admin/inputManager";
import { $, $$ } from "../funcs";
import dadata from "./api";


const urls = {
    forms: {
        json: "https://иск.онлайн/формы/получение/",
        post: "https://иск.онлайн/обработка-сервиса/",
    }
}

class Form {
    constructor (div) {
        // Корневой элемент
        this.el = div;

        // Токен
        this.token = $('[name="_token"]', div).value;

        // Заявление
        this.application = this.el.dataset.application ? this.el.dataset.application : 0;

        // JSON
        this.json = {};
        this.service = 0;

        this.step = 0;

        // Значения
        this.values = {};

        // Наименования полей
        this.aliases = {};

        // Список функций валидации текущего шага
        this.validations = [];

        // Обработанные элементы
        this.handledElements = [];

        // Получение данных
        fetch(`${urls.forms.json}${this.el.dataset.initForm}?application=${this.application}`).then(r => r.json()).then(r => {
            this.json = r.form;

            this.service = this.json.service;
            this.values = r.values;

            // Сортировка шагов
            let steps = this.json.steps;
            steps.sort((a, b) => {
                if (a.order > b.order) return 1;
                if (a.order == b.order) return 0;
                if (a.order < b.order) return -1;
            });

            this.json.steps = steps;

            // Рендер всего
            this.render();
        });
    }

    // Поиск элемента в json по element_name
    getElement(name, json=this.json.steps[this.step].elements) {
        let finded = null;

        // Рекурсивный поиск элементов по element_name
        json.forEach(element => {
            // Если нашли, то записываем
            if (element.element_name == name) {
                finded = element;
            } else {
                // Если не нашли, ищем у детей
                if (element.elements) {
                    let f = this.getElement(name, element.elements);
                    finded = f ? f : finded;
                }
            }
        });

        return finded;
    }

    // Поиск и изменение значения элемента в json по element_name
    setElementValue(
        name, 
        value, 
        json=this.json.steps[this.step].elements, 
        prefixes=(this.json.steps[this.step].prefix ? [this.json.steps[this.step].prefix] : [])
        ) {

        // Рекурсивный поиск элементов по element_name 
        json.forEach(element => {
            // Если нашли, то записываем
            if (element.element_name == name) {
                this.values[([...prefixes, element.name]).join('-')] = value;
            } else {

                // Если не нашли, ищем у детей
                if (element.elements) {
                    this.setElementValue(
                        name, 
                        value,
                        element.elements,
                        element.prefix ? [...prefixes, element.prefix] : prefixes
                    );
                }
            }
        });

    }

    // Сохранение значений
    saveInputs() {
        let values = saveInputs(this.el);
        for (let key in values) {
            this.values[key] = values[key];
        }
    }

    // Создание подписи
    makeFeedback(input, cls, text) {
        $('.feedback', input.parentNode).className = `feedback ${cls}`;
        $('.feedback', input.parentNode).innerHTML = text;
    }

    // Подсветка поля
    highlightField(input, valid) {
        
        input.classList.remove('is-valid');
        input.classList.remove('is-invalid');

        input.classList.add(valid ? 'is-valid' : 'is-invalid');
    }

    // Валидация
    validate() {
        let isValid = true;

        this.validations.forEach(validation => {
            
            let input = validation.el;
            
            if (input) {
                this.highlightField(input, true);
                this.makeFeedback(input, 'valid-feedback', "Всё в порядке");

                let texts = [];
                
                validation.funcs.forEach(func => {
                    let res = func();
                    if (res) {
                        texts.push(res);
                    }
                });

                if (texts.length) {
                    isValid = false;
                    this.highlightField(input, false);
                    this.makeFeedback(input, 'invalid-feedback', texts.join('<br>'));
                }    
            }
            
        });

        return isValid;
    }

    // Работа программы
    parseProgramm(el, input, cmds) {

        // Действия команд
        let types = {
            "alert": (cmd) => console.log(el.value),
            "error": (cmd) => cmd.options.error,
            "if-value": (cmd) => this.parseProgramm(el, input, getElementValue(el) == cmd.options.val ? cmd.areas[0] : []),
            "if-value-else": (cmd) => this.parseProgramm(el, input, getElementValue(el) == cmd.options.val ? cmd.areas[0] : cmd.areas[1]),
            "hide": (cmd) => {
                this.getElement(cmd.options.field).options.hidden = true;
                this.render();
            },

            "show": (cmd) => {
                this.getElement(cmd.options.field).options.hidden = false;
                this.render();
            },

            "company-by-name": (cmd) => {
                setTimeout(() => {
                    this.saveInputs();
                    dadata.getCompany(getElementValue(el), company => {
                        this.setElementValue(cmd.options.inn, company.data.inn);
                        this.setElementValue(cmd.options.addr, company.data.address.unrestricted_value);
                        this.render();
                    });
                }, 200);
            },
            "company-by-inn": (cmd) => {
                setTimeout(() => {
                    this.saveInputs();
                    dadata.getCompany(getElementValue(el), company => {
                        this.setElementValue(cmd.options.name, company.data.name.full_with_opf);
                        this.setElementValue(cmd.options.addr, company.data.address.unrestricted_value);
                        this.render();
                    });
                }, 200);
            },
            "bank-by-bik": (cmd) => {
                setTimeout(() => {
                    this.saveInputs();
                    dadata.getBank(getElementValue(el), bank => {
                        this.setElementValue(cmd.options.name, bank.value);
                        this.setElementValue(cmd.options.corr, bank.data.correspondent_account);
                        this.render();
                    });
                }, 200);
            },
            "bank-by-name": (cmd) => {
                setTimeout(() => {
                    this.saveInputs();
                    dadata.getBank(getElementValue(el), bank => {
                        this.setElementValue(cmd.options.bik, bank.data.bic);
                        this.setElementValue(cmd.options.corr, bank.data.correspondent_account);
                        this.render();
                    });
                }, 200);
            },
        }

        // Перебор команд
        let res = null;
        cmds.forEach(cmd => {
            if (types[cmd.type]) {
                res = res ? res : types[cmd.type](cmd);
            }
        });

        return res;
    }

    // Следующий шаг
    next() {
        this.saveInputs();

        if (this.step == this.json.steps.length - 1) {
            this.finish();
            return;
        }

        this.step += 1;
        this.render();
    }

    // Следующий шаг
    prev() {
        this.step = Math.max(0, this.step - 1);
        this.render();
    }

    // Рендер общий
    render() {
        
        // Очистка списка функций валидации
        this.validations = [];

        // Очистка содержимого элемента
        this.el.innerHTML = ``;

        let currentStep = this.json.steps[this.step];

        // Рендерим шаг
        this.renderStep();

        // Получение важных элементов
        let nextStepBtn = $('[data-next-step]', this.el);
        let prevStepBtn = $('[data-prev-step]', this.el);
        let area = $('ul', this.el);

        // Рендер дочерних элементов шага
        this.renderChildren(currentStep.elements, area, currentStep.prefix ? [currentStep.prefix] : []);

        nextStepBtn.onclick = () => {
            if (this.validate()) {
                this.next();
            }
        }

        if (prevStepBtn) {
            prevStepBtn.onclick = () => {
                this.saveInputs();
                this.prev();
            }    
        }
        
    }

    // Отрисовка дочерних элементов
    renderChildren(elements, area, prefixes) {
        Array.from(area.children).forEach(ch => ch.remove());

        elements.forEach((element, i) => {
            // Отрисовка элемента
            this.renderElement(element, Math.trunc(Math.random() * 10000), area, element.prefix ? [...prefixes, element.prefix] : prefixes, elements);
            
        });
    }

    // Универсальный рендер элементов
    renderElement(element, i, area, prefixes, neighbours) {
        let childArea = null;

        if (+element.options.hidden) {
            return;
        }

        switch (element.type) {
            case "group":
                childArea = this.renderGroup(element, i, area, prefixes, neighbours);
                break;

            case "input":
                this.renderInput(element, i, area, prefixes);
                break;
        }

        if (childArea) {
            this.renderChildren(element.elements, childArea, prefixes);
        }
    }


    // Рендер поля
    renderInput(input, i, area, prefixes) {
        // HTML контейнера поля ввода
        let html = `
            <li class="col-12 col-md-${input.column} mt-2 " id="element${i}" data-element-id="${input.element_id}">
            </li>
        `;

        area.insertAdjacentHTML('beforeend', html);

        // Элемент
        let li = $(`#element${i}`, area);

        // Получение контейнера инпута и добавление в элемент
        let name = [...prefixes, input.name].join('-');
        this.aliases[name] = input.id;

        // Подготовка событий
        let events = [];

        events.push({type: 'change',  action: _ => this.saveInputs()});

        input.events.forEach(ev => {
            events.push({type: ev.type, action: i => this.parseProgramm(i, input, ev.areas[0])});

            if (ev.type == 'change' && !this.handledElements.includes(name)) {
                events.push({type: "init", action: i => this.parseProgramm(i, input, ev.areas[0])});
                this.handledElements.push(name);
            }
        });

        // Рендер элемента
        let validations = {el: null, funcs: []};

        let inputEl = rInp(input, this.values[name] ? this.values[name] : '', events, name, validations);
        li.appendChild(inputEl);


        this.validations.push(validations);

    }

    // Рендер группы
    renderGroup(group, i, area, prefixes, neighbours) {
        // Настройки группы
        let border = +group.options.border;
        let show_name = +group.options.show_name;

        // HTML группы
        let html = `
            <li class="col-12 col-md-${group.column} ${show_name ? "mt-3" : ""}" id="element${i}" data-element-id="${group.element_id}">
                <div class="${border ? 'fieldset rounded border p-3 ' : ''}">
                    ${show_name ? `<div class='legend ${border ? 'px-2' : ''} text-muted'>
                        ${group.name} 
                    </div>` : ''}
                    <ul class="row" data-area data-group-area="${group.id}" data-parent-table="form_ui_groups" data-parent-id="${group.id}">
                        
                    </ul>
                    ${group.description ? `<p>${group.description}</p>` : ``}
                    ${group.clonable && group.prefix ? 
                    group.prefix.includes('__') ? `<button data-remove-group class="btn btn-danger mt-2">Убрать</button>` : `<button data-clone-group class="btn btn-primary mt-2">Добавить</button>` :
                    ``
                    }

                </div>
            </li>
        `;
        
        // Вставка кода группы
        area.insertAdjacentHTML('beforeend', html);
        let groupArea = $(`#element${i} [data-area]`, area);
        
        // Если группа дублируемая
        if (group.clonable) {
            let cloneBtn = $(`#element${i} [data-clone-group]`, area);
            let removeBtn = $(`#element${i} [data-remove-group]`, area);

            if (cloneBtn) {
                cloneBtn.onclick = () => {
                    this.saveInputs();
                    this.cloneGroup(group, neighbours);

                    this.render();
                }
            }

            if (removeBtn) {
                removeBtn.onclick = () => {
                    this.saveInputs();
                    this.removeGroup(group, neighbours);

                    this.render();
                }
            }
        }


        return groupArea;
    }

    // Дублирование групп
    cloneGroup(group, neighbours) {
        let basePrefix = group.prefix;

        let i = 0;
        neighbours.forEach(neighbour => {
            if (neighbour.prefix) {
                if (neighbour.prefix.split('__')[0] == basePrefix) {
                    if (i > 0) {
                        neighbour.prefix = basePrefix + `__${i}`;
                    }
                    i += 1;
                }
            }
        });

        let clone = JSON.parse(JSON.stringify(group));
        clone.prefix += `__${i}`;
        neighbours.push(clone);
    }

    // Удаление группы
    removeGroup(group, neighbours) {
        let basePrefix = group.prefix.split("__")[0];
        let prefix = group.prefix;

        let i = 0;
        neighbours.forEach((neighbour, j) => {
            if (neighbour.prefix) {
                if (neighbour.prefix == prefix) {
                    delete neighbours[j];
                    i = j;
                }
            }
        });

        this.removeValues(basePrefix, +prefix.split("__")[1]);

        i = 0;
        neighbours.forEach(neighbour => {
            if (neighbour.prefix) {
                if (neighbour.prefix.split('__')[0] == basePrefix) {
                    if (i > 0) {
                        neighbour.prefix = basePrefix + `__${i}`;
                    }
                    i += 1;
                }
            }
        });
    }

    // Перенос значений при удалении имени
    removeValues(prefix, i) {
        let indexes = Object.keys(this.values).filter(key => key.includes(`${prefix}__`));
        let newValues = {};

        indexes.forEach(ind => {
            let order = ind.split(`${prefix}__`)[1].split('-')[0];

            if (order < i) {
                newValues[ind.replace(`${prefix}__${order}-`, `${prefix}__${order}-`)] = this.values[ind];
            } else if (order > i) {
                newValues[ind.replace(`${prefix}__${order}-`, `${prefix}__${order - 1}-`)] = this.values[ind];
            }
        });

        indexes.forEach(ind => {
            delete this.values[ind];
        });

        for (let key in newValues) {
            this.values[key] = newValues[key];
        }
    }

    // Рендер шага
    renderStep() {
        // HTML шага
        let stepHTML = `
        <div class="form-blue">
            <h2>${this.json.title}</h2>
            <!--div class="mt-3 d-flex align-items-center gap-2"-->
            <div class="form-service__wrapper">
                ${this.step > 0 ? `<span data-prev-step role="button" class="form-service__step-prev"><svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 1L2 8L9 15" stroke="white" stroke-width="2"/></svg></span>` : ``}
                <span class="form-service__steps">${this.step + 1} / ${this.json.steps.length}</span> 
                <h3>${this.json.steps[this.step].title}</h3>
            </div>
            <ul class="row"></ul>
            <button data-next-step class="btn btn--black btn-next">Далее</button>
        </div>
        `;

        // Сохранение содержимого элемента
        this.el.insertAdjacentHTML('beforeend', stepHTML);
    }

    // Отправка формы
    finish() {

        let fd = new FormData();
        for (let key in this.values) {
            if (String(this.values[key]).startsWith('blob:') || String(this.values[key]).startsWith('data:')) {
                fetch(this.values[key]).then(r => r.blob()).then(blob => {
                    fd.append(key, blob);
                });
            } else {
                fd.append(key, this.values[key]);
            }
        }

        fd.append('aliases', JSON.stringify(this.aliases));
        fd.append('_token', this.token);

        // Плашка с загрузкой
        let nextStepBtn = $('[data-next-step]', this.el);
        nextStepBtn.innerHTML = `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Загрузка...`;

        setTimeout(() => {
            fetch(`${urls.forms.post}${this.service}/1?application=${this.application}`, {
                method: 'POST',
                body: fd
            }).then(r => r.json()).then(content => {

                if (content.to) {
                    window.location.href = content.to;
                } else {
                    
                    nextStepBtn.innerHTML = `Заполнить ещё раз`;
                    nextStepBtn.onclick = () => {
                        this.step = 0;
                        this.render();
                    }
                    console.log(content);
                    if (content.msg) {
                        $('ul', this.el).innerHTML = `<li><h4>Результат:</h4><br>${content.msg}</li>`;
                    }

                    if (content.error) {
                        $('ul', this.el).insertAdjacentHTML('beforeend', `<h4 class='text-danger'>Упс, у нас возникла ошибка:<br>${content.error}</h4>`);
                    }    
                }

                
            });    
        }, 400);
        
    }
}

// Функция нахождения инициализирующих дивов форм и их активации
const checkForms = () => {
    $$('[data-init-form]').forEach(div => {
        new Form(div);
    })
}

export default checkForms;