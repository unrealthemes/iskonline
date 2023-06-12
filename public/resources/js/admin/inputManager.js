import dadata from "../calc/api";
import { $, $$ } from "../funcs";
import padInit from "../sketchpad";


const inputManager = (area, type, options={}) => {
    area.innerHTML = ``;

    switch (type) {
        
        // Число
        case "number":

            area.insertAdjacentHTML('beforeend', `
                <div class='col-3'>
                    ${optionInput("options-min", "Мин. значение", options.min, "type='number'")}
                </div>
            `);

            area.insertAdjacentHTML('beforeend', `
                <div class='col-3'>
                    ${optionInput("options-max", "Макс. значение", options.max, "type='number'")}
                </div>
            `);

            break;
        
        // Радио-кнопка
        case "radio":

            area.insertAdjacentHTML('beforeend', `
                <div class='col-12'>
                    ${optionInput("options-value", "Значение", options.value, "required")}
                </div>
            `);

            break;

        // Селект
        case "select":

            area.insertAdjacentHTML('beforeend', `
                <div class='col-12'>
                    ${optionTextarea("options-options", "Варианты", options.options, "required rows='5'")}
                    <span class='text-muted'>*Варианты разделяются ";", в рамках варианта значение и подпись разделяются "=". Например,<br>value1=Вариант 1;<br>value2=Вариант 2;<br>value3=Вариант 3</span>
                </div>
            `);

            break;
        
        // Файл
        case "file":

            area.insertAdjacentHTML('beforeend', `
                <div class='col-12'>
                    ${optionSelect("options-filetypes", "Формат файла", options.filetypes, "", options=[
                        {value: "*", label: "Любой файл"},
                        {value: "image/*", label: "Картинка"},
                        {value: "application/pdf", label: "PDF-документ"},
                        {value: "application/vnd.openxmlformats-officedocument.wordprocessingml.document", label: "DOCX-файл"},
                    ])}
                    <span class='text-muted'>*MIME-типы файлов через запятую</span>
                </div>
            `);

            break;
        
        // Остальное
        default:
            area.insertAdjacentHTML('beforeend', `<p>У этого типа полей нет настроек</p>`);
            break;
    }
}

const optionInput = (name, label, value="", attrs="") => {
    return `
        <div class="mb-3">
            <label for="${name}" class="form-label">${label}</label>
            <input ${attrs} type="text" class="form-control" id="${name}" name="${name}" value="${value}">
        </div>
    `;
}

const optionSelect = (name, label, value="", attrs="", options=[]) => {
    let optionsHtml = "";

    options.forEach(opt => {
        optionsHtml += `<option value="${opt.value}" ${opt.value == value ? "selected" : ""}>${opt.label}</option>`;
    })

    return `
        <div class="mb-3">
            <label for="${name}" class="form-label">${label}</label>
            <select class="form-select" ${attrs} id="${name}" name="${name}">
                ${optionsHtml}
            </select>
        </div>
    `;
}

const optionTextarea = (name, label, value="", attrs="") => {
    return `
        <div class="mb-3">
            <label for="${name}" class="form-label">${label}</label>
            <textarea ${attrs} class="form-control" id="${name}" name="${name}" >${value}</textarea>
        </div>
    `;
}

const optionCheckbox = (name, label, value="") => {
    return `
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" ${value ? "checked" : ""} id="${name}" name="${name}">
                <label class="form-check-label" for="${name}">
                    ${label}
                </label>
            </div>
        </div>
    `;
}

const inputTypes = {
    "text": "Строка",
    "number": "Число",
    "date": "Дата",
    "checkbox": "Чекбокс",
    "radio": "Радио-кнопка",
    "select": "Выбор из нескольких",
    "file": "Файл",
    "textarea": "Абзац",
    "fio": "ФИО",
    "tel": "Телефон",
    "email": "Email",
    "passport": "Паспорт (серия и номер)",
    "address": "Адрес",
    "inn": "ИНН",
    "company_name": "Название компании",
    "bank_name": "Название банка",
    "bik": "БИК банка",
    "court": "Название участка мирового судьи",
    "sign": "Подпись",
    "bank_card": "Банковская карта",
};

// Рендер поля ввода
const renderInput = (inp, value, events, name, validations={el: null, funcs: []}) => {
    let input = null;

    value = String(value).replaceAll('"', '&quot;');
    switch (inp.input_type) {
        case "checkbox":
            input = renderCheckbox(inp, value, events, name, validations);
            break;

        case "radio":
            input = renderRadio(inp, value, events, name, validations);
            break;

        case "number":
            input = renderNumber(inp, value, events, name, validations);
            break;
        
        case "select":
            input = renderSelect(inp, value, events, name, validations);
            break;
        
        case "file":
            input = renderFile(inp, value, events, name, validations);
            break;
        
        case "fio":
            input = renderFio(inp, value, events, name, validations);
            break;
        
        case "tel":
            input = renderTel(inp, value, events, name, validations);
            break;

        case "address":
            input = renderAddress(inp, value, events, name, validations);
            break;
        
        case "inn":
            input = renderInn(inp, value, events, name, validations);
            break;
        
        case "company_name":
            input = renderCompanyName(inp, value, events, name, validations);
            break;
        
        case "bank_name":
            input = renderBankName(inp, value, events, name, validations);
            break;
        
        case "bik":
            input = renderBik(inp, value, events, name, validations);
            break;

        case "court":
            input = renderCourtName(inp, value, events, name, validations);
            break;
        
        case "sign":
            input = renderSign(inp, value, events, name, validations);
            break;

        case "passport":
            input = renderPassport(inp, value, events, name, validations);
            break;

        case "bank_card":
            input = renderBankCard(inp, value, events, name, validations);
            break;
        
        default:
            input = renderDefaultInput(inp, value, events, name, validations);
            break;
    }


    if (inp.helper) {
        
        let helper = `<div data-fancybox="${inp.name}" data-caption="Подсказка" href="${inp.helper.img}" class="mt-1 badge bg-primary" role="button"><i class="fa-solid fa-circle-question"></i></div>`;    
        input.insertAdjacentHTML('beforeend', helper);
    }

    return input;
}

// Создание div'а
const mkDiv = (cls, html) => {
    let div = document.createElement('div');
    div.className = `w-100 ${cls}`;
    div.innerHTML = html;

    return div;
}

// Обработка событий
const defaultHandleEvents = (el, events, validations) => {

    events.forEach(ev => {
        el.addEventListener(ev.type, () => ev.action(el));
 
        if (ev.type == 'next') {
            validations.el = el;
            validations.funcs.push(() => ev.action(el));
        }

        if (ev.type == 'init') {
            ev.action(el);
        }
    });
    
    // Очистка фидбека при изменении значения
    el.addEventListener('input', () => {
        clearFeedback(el.parentNode);
    });
}

// Функция фидбека
const feedback = () => {
    return `<div class='feedback'></div>`;
}

// Функция даталиста
const datalist = () => {
    return `<div style="display: none;" class='datalist shadow rounded overflow-hidden'></div>`;
}

// Очистка фидбека
const clearFeedback = (el) => {
    $('.feedback', el).className = 'feedback';
    $('.feedback', el).innerHTML = '';

    $$('.is-valid, .is-invalid', el).forEach(v => {
        v.classList.remove('is-valid');
        v.classList.remove('is-invalid');
    });
}

// Добавление звёздочки в лабел
const addRequired = (div, inp) => {
    let label = $('label', div);
    if (label && +inp.options.required) {
        label.innerHTML += ` <span class="d-flex-inline align-items-center text-danger">*</span>`;
    }
}

// ===== РЕНДЕР ПОЛЕЙ =====

// Рендер по умолчанию
const renderDefaultInput = (inp, value, events, name="", validations={}, type="") => {
    let html = `
        <input data-name="${inp.element_name}" type="${type ? type : inp.input_type}" class="form-control" id="${name}" name="${name}" placeholder="${inp.label}" value="${value}">
        <label for="${name}">${inp.label}</label>
        ${feedback()}
    `;

    let div = mkDiv('form-floating', html);
    addRequired(div, inp);

    let input = $('input', div);

    // Цепляем валидацию
    validations.el = input;
    if (+inp.options.required) {
        validations.funcs.push(_ => {
            return String(input.value).length ? null : "Заполните это поле!";
        });
    }

    // Цепляем события
    defaultHandleEvents(input, events, validations);

    return div;
}

// Рендер чекбокса
const renderCheckbox = (inp, value, events, name="", validations={}) => {
    let html = `
        <input data-name="${inp.element_name}" type="checkbox" class="form-check-input" id="${name}" name="${name}" placeholder="${inp.label}" ${+value ? "checked" : ""}>
        <label class="form-check-label" for="${name}">${inp.label}</label>
        ${feedback()}
    `;

    let div = mkDiv('form-check', html);
    addRequired(div, inp);

    let input = $('input', div);
    
    // Цепляем валидацию
    validations.el = input;
    if (+inp.options.required) {
        validations.funcs.push(_ => {
            return input.checked ? null : "Отметьте этот пункт!";
        });
    }

    // Цепляем события
    defaultHandleEvents(input, events, validations);

    return div;
}

// Рендер радиобокса
const renderRadio = (inp, value, events, name="", validations={}) => {
    let i = Math.trunc(Math.random() * 1000);
    let html = `
        <input ${value ? (value == inp.options.value ? 'checked' : '') : 'checked' } data-name="${inp.element_name}" type="radio" class="form-check-input" id="${name}${i}" name="${name}" placeholder="${inp.label}" value="${inp.options.value}" ${inp.options.value == value ? "checked" : ""}>
        <label class="form-check-label" for="${name}${i}">${inp.label}</label>
        ${feedback()}
    `;

    let div = mkDiv('form-check', html);
    addRequired(div, inp);
    
    let input = $('input', div);

    
    // Цепляем валидацию
    // validations.el = input;

    // Цепляем события
    defaultHandleEvents(input, events, validations);

    return div;
}

// Рендер селекта
const renderSelect = (inp, value, events, name="", validations={}) => {

    let options = "";

    inp.options.options.split(";").forEach(opt => {
        let val = opt.split("=")[0].replaceAll("\n", "").replaceAll("\r", "");
        let text = opt.split("=")[1].replaceAll("\n", "").replaceAll("\r", "");
        options += `<option ${value == val ? "selected" : ""} value="${val.replaceAll('"', '&quot;')}">${text}</option>`;
    });

    let html = `
        <select data-name="${inp.element_name}" type="${inp.input_type}" class="form-select" id="${name}" name="${name}" aria-label="${inp.label}">
            ${options}
        </select>
        <label for="${name}">${inp.label}</label>
        ${feedback()}
    `;

    let div = mkDiv('form-floating', html);
    addRequired(div, inp);

    let input = $('select', div);
    
    // Цепляем валидацию
    validations.el = input;

    // Цепляем события
    defaultHandleEvents(input, events, validations);

    return div;
}

// Рендер файла
const renderFile = (inp, value, events, name="", validations={}) => {

    let html = `
        <label for="${name}">${inp.label}</label>
        <input type="${inp.input_type}"  accept="${inp.options.filetypes}" class="form-control" id="${name}" name="${name}" aria-label="${inp.label}">
        ${feedback()}
        ${value ? 
        `<div class='mt-2 alert alert-secondary'><a target="_blank" href='${value}' class='text-primary'>Ранее загруженный файл</a></div>` :
        ``
        }
    `;

    let div = mkDiv('', html);
    addRequired(div, inp);

    
    let input = $('input', div);
    
    // Цепляем валидацию
    validations.el = input;

    // Цепляем события
    defaultHandleEvents(input, events, validations);

    return div;
}

// Рендер файла
const renderSign = (inp, value, events, name="", validations={}) => {

    let html = `
    <div class="d-flex flex-column align-items-center inp ${value ? 'confirmed' : ''}" data-sign-name='${name}'>
        <p>Поставьте Вашу подпись здесь (мышкой или пальцем)</p>
        <div class="shadow rounded border border-gray pad mt-2 mb-2"></div>
        <div class="d-flex gap-1">
            ${value ? "" : `<button type='button' class='btn btn-primary btn-clear' role='button'>Очистить подпись</button><button type='button' class='btn btn-success btn-confirm' role='button'>Подтвердить подпись</button>`}
        </div>
    </div>
    ${feedback()}
    `;

    let div = mkDiv('', html);
    addRequired(div, inp);

    let input = $('[data-sign-name]', div);
    
    let padEl = input.children[1];
    let pad = padInit(padEl, value ? true : false);

    let cnv = $('canvas', input);
    let fixed = value ? true : false;

    // Если уже есть значение, фиксируем подпись
    if (value) {
        let ctx = cnv.getContext('2d');
        
        let img = new Image();
        img.src = value;
        img.onload = () => {
            ctx.drawImage(img, 0, 0);
        }
        cnv.style.opacity = 0.5;
    }

    let btnConfirm = $('.btn-confirm', input);
    let btnClear = $('.btn-clear', input);

    // Вешаем событие на кнопку фиксации подписи
    if (btnConfirm) {
        btnConfirm.onclick = e => {
            e.preventDefault();

            if (confirm("Вы хотите подтвердить и зафиксировать подпись? Изменить её будет нельзя!")) {
                pad.setReadOnly(true);
                cnv.style.opacity = 0.5;

                btnConfirm.remove();
                btnClear.remove();

                fixed = true;

                clearFeedback(div);
            }
            
        }    
    }

    // Цепляем валидацию
    validations.el = input;

    // Цепляем события
    defaultHandleEvents(input, events, validations);

    // Проверка фиксации подписи
    validations.funcs.push(() => fixed ? false : "Необходимо зафиксировать подпись!");

    return div;
}

// Помощник в рендере полей с подсказками
const suggestedRenderHelper = (inp, value, events, name="", validations={}, type, suggestion) => {
    let div = renderDefaultInput(inp, value, events, name, validations, type);

    div.insertAdjacentHTML('beforeend', datalist());
    
    let input = $('input', div);
    input.addEventListener('input', _ => {
        dadata.suggest(suggestion, input);
    });

    input.addEventListener('blur', _ => {
        setTimeout(() => { dadata.makeSuggestions(input, []) }, 100);
    });

    return div;
}


// Рендер ФИО
const renderFio = (inp, value, events, name="", validations={}) => {
    return suggestedRenderHelper(inp, value, events, name, validations, 'string', 'fio');
}

// Рендер Адреса
const renderAddress = (inp, value, events, name="", validations={}) => {
    return suggestedRenderHelper(inp, value, events, name, validations, 'string', 'address');
}

// Рендер ИНН
const renderInn = (inp, value, events, name="", validations={}) => {
    return suggestedRenderHelper(inp, value, events, name, validations, 'number', 'inn');
}

// Рендер Название компании
const renderCompanyName = (inp, value, events, name="", validations={}) => {
    return suggestedRenderHelper(inp, value, events, name, validations, 'string', 'company_name');
}

// Рендер наименования банка
const renderBankName = (inp, value, events, name="", validations={}) => {
    return suggestedRenderHelper(inp, value, events, name, validations, 'string', 'bank');
}

// Рендер БИК банка
const renderBik = (inp, value, events, name="", validations={}) => {
    return suggestedRenderHelper(inp, value, events, name, validations, 'number', 'bik');
}

// Рендер мирового суда
const renderCourtName = (inp, value, events, name="", validations={}) => {
    return suggestedRenderHelper(inp, value, events, name, validations, 'string', 'court');
}

// Рендер телефона
const renderTel = (inp, value, events, name="", validations={}) => {
    let div = renderDefaultInput(inp, value, events, name, validations, "tel");

    jQuery(function($){
        $("[type=tel]").mask("+7 (999) 999-99-99");
    });

    return div;
}

// Рендер паспорта
const renderPassport = (inp, value, events, name="", validations={}) => {
    let div = renderDefaultInput(inp, value, events, name, validations, "string");
    
    jQuery(function($){
        $(`[name="${name}"]`).mask("9999 999999");
    });

    return div;
}

// Рендер банковской карты
const renderBankCard = (inp, value, events, name="", validations={}) => {
    let div = renderDefaultInput(inp, value, events, name, validations, "string");
    
    jQuery(function($){
        $(`[name="${name}"]`).mask("9999 9999 9999 9999");
    });

    return div;
}


// Рендер числа
const renderNumber = (inp, value, events, name="", validations={}) => {
    let div = renderDefaultInput(inp, value, events, name, validations, "number");

    let input = $('input', div);

    // Мин - макс
    if (inp.options.min) {
        validations.funcs.push(_ => {
            return +input.value >= +inp.options.min ? null : `Значение должно быть не менее ${inp.options.min}!`;
        });
    }
    
    if (inp.options.max) {
        validations.funcs.push(_ => {
            return +input.value <= +inp.options.max ? null : `Значение должно быть не более ${inp.options.max}!`;
        });
    }

    return div;
}

// ===== РАБОТА С ДАННЫМИ =====

// Получение данных
const getValue = (name) => {
    let el = $(`[data-name="${name}"]`);

    return getElementValue(el);
}

// Получение значения элемента
const getElementValue = (el) => {
    let value = el.value;
    if (el.type == 'checkbox') {
        value = +el.checked;
    }

    return value;
}

// Сохранение значений
const saveInputs = (el) => {
    let values = {};

    // Сохранение инпутов, селектов, чекбоксов и радиобоксов
    Array.from($$('input, select', el)).filter(el => (el.type != 'radio' || el.checked) && el.type != 'file').forEach(el => {
        values[el.name] = el.type != "checkbox" ? el.value : +el.checked;
    });

    // Сохранение файлов. В файл будет положен url на blob файла
    Array.from($$('input[type=file]', el)).forEach(el => {
        const files = el.files;
        if (files.length) {
            values[el.name] = window.URL.createObjectURL(files[0]);
        }
    });

    // Сохранение подписи
    Array.from($$('[data-sign-name]', el)).forEach(sign => {
        let cnv = $('canvas', sign);
        values[sign.dataset.signName] = cnv.toDataURL();
    })

    return values;
}


export default inputManager;
export {inputTypes, renderInput, getValue, getElementValue, saveInputs};