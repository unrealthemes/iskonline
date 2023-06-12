import { $, $$ } from "../funcs";
import dadata from "./api";
import padInit from "../sketchpad";

class Calculator {
    constructor(el, json) {
        this.el = el;
        this.json = json;

        this.title = $('.calculator-title', el);
        this.stepTitle = $('.calculator-step-title', el);
        this.content = $('.calculator-content', el);
        this.description = $('.calculator-description', el);
        this.btn = $('.calculator-btn', el);
        this.step = 1;

        this.stepsHistory = [];

        this.build();

        // Отключаем форму
        $('form', this.el).onsubmit = ev => ev.preventDefault();
    }

    clearValidation(input) {
        input.classList.remove('is-valid');
        input.classList.remove('is-invalid');
    }

    setFeedback(input, type, text) {
        let feedback = $('.feedback', input.parentNode);
        feedback.classList.remove('valid-feedback');
        feedback.classList.remove('invalid-feedback');
        feedback.classList.add(`${ type ? '' : 'in'}valid-feedback`);
        feedback.innerHTML = text;
    }

    inputByJson(step, inp) {
        // Получение кода поля ввода
        let json = this.json.steps[step].inputs[inp];
        
        let group = document.createElement('div');
        group.className = `${json.type == 'file' ? '' : 'form-floating'} mb-3`;

        let input = '';
        // Выбор типов полей
        if (json.type == 'textarea') {
            input = `
            <textarea 
                name="${json.name}" 
                id="${json.name}" 
                cols="30" 
                rows="6" 
                class="form-control inp"
                placeholder="${json.label}"
            >${json.value}</textarea>
            `;
        } else if (json.type == 'select') {
            input = `
            <select
                name="${json.name}" 
                id="${json.name}" 
                class="form-select inp"
                placeholder="${json.label}" 
            >
                ${ json.options.map(option => `<option value="${option.id}" ${option.id == json.value ? 'selected' : ''}>${option.text}</option>`).join("") }
            </select>
            `;
        } else if (json.type == 'sign') {
            input = `
                <div class="d-flex flex-column align-items-center inp ${json.value ? 'confirmed' : ''}" data-name='${json.name}'>
                    <p>Поставьте Вашу подпись здесь (мышкой или пальцем)</p>
                    <div class="shadow rounded bg-white border border-gray pad mt-2 mb-2"></div>
                    <div class="d-flex gap-1">
                        ${json.value ? "" : `<button type='button' class='btn btn-primary btn-clear' role='button'>Очистить подпись</button><button type='button' class='btn btn-success btn-confirm' role='button'>Подтвердить подпись</button>`}
                    </div>
                    
                </div>
            `;
        } else {
            input = `<input 
                type="${ json.type }" 
                ${ json.multiple ? 'multiple' : '' } 
                name="${json.name}" 
                id="${json.name}" 
                ${ json.value ? `value='${json.value}'` : '' } 
                placeholder="${json.label}" 
                class="form-control inp"
                ${json.accept ? `accept='${json.accept}'` : ""}
            >`;
        }

        // Подпись
        let label = `<label for="${json.name}">${json.label}</label>`;

        // Пояснение
        let helper = '';

        if (json.helper_image) {
            helper = `<div data-fancybox="${json.name}" data-caption="${json.helper_caption}" href="${json.helper_image}" class="mt-1 badge bg-primary"><img width="25px" src='/images/helper.svg'> Где это найти?</div>`;
        }

        if (json.type == 'button')
            label = '';

        // Сообщение об ошибке
        let validationFeedback = `<div class="feedback valid-feedback"></div>`;

        // Подсказки
        let datalist = '';
        if (json.suggestions) {
            datalist = `<div id='${json.name}-datalist' style="display: none;" class='datalist shadow rounded overflow-hidden'>
            </div>`;
        }
        
        // Добавление компонентов в группу
        group.innerHTML = input + label + helper + datalist + validationFeedback;

        // Работа с полем
        input = $('.inp', group);
        input.addEventListener('input', () => {
            this.json.steps[step].inputs[inp].value = input.value;
            this.clearValidation(input);
        });

        if (json.disabled) {
            input.disabled = true;
        }
        
        if (json.type == 'sign') {
            let pad = input.children[1];
            padInit(pad, json.value ? true : false);

            let cnv = $('canvas', input);
            if (json.value) {
                let ctx = cnv.getContext('2d');
                
                let img = new Image();
                img.src = json.value;
                img.onload = () => {
                    ctx.drawImage(img, 0, 0);
                }
                cnv.style.opacity = 0.5;
            }

            let btnConfirm = $('.btn-confirm', input);
            if (btnConfirm) {
                btnConfirm.onclick = e => {
                    e.preventDefault();

                    if (confirm("Вы хотите подтвердить и зафиксировать подпись? Изменить её будет нельзя!")) {
                        this.json.steps[step].inputs[inp].value = cnv.toDataURL();
                        this.build();    
                    }
                    
                }    
            }
            
        } else {
            if (json.type == 'file') {

            } else {
                this.json.steps[step].inputs[inp].value = input.value;  
            }
            
        }
        

        // Если это кнопка
        if (json.type == 'button') {
            group.classList.remove('form-floating');
            input.value = json.label;
            input.classList.add('btn');
            input.classList.add('btn-primary');
            input.classList.remove('form-control');
        }

        // Контроль ввода
        if (json.type == 'tel') {
            
        }
        
        // Привязка подсказок
        if (json.suggestions) {
            input.setAttribute('data-list', `${json.name}-datalist`);
            input.addEventListener('input', () => {
                dadata.suggest(json.suggestions, input);
            });
            input.addEventListener('blur', () => {
                setTimeout(() => $(`#${json.name}-datalist`, group).style.display = "none", 200);
            })
        }

        // Привязка событий

        if (json.events) {
            for (let event in json.events) {
                if (event == 'init') {
                    this.doAction(input, {step, inp}, json.events[event]);
                    continue;
                }

                input.addEventListener(event, () => 

                    this.doAction(input, {step, inp}, json.events[event]),
                );
            }
        }
        

        return group;
    }

    validateInput(input, validation) {
        switch (validation.type) {
            case 'tel':
                if (/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/.test(input.value))
                    return true;
                this.setFeedback(input, false, 'Неверный формат телефона');
                return false;
            case 'fio':
                if (input.value.split(' ').length != 3) {
                    this.setFeedback(input, false, 'Неверный формат ФИО');
                    return false;
                }
                let middlename = input.value.split(' ')[2];
                if (middlename.endsWith('вна') || middlename.endsWith('вич')) {
                    return true;
                }
                this.setFeedback(input, false, 'Неверный формат ФИО');
                return false;
            case 'email':
                if (/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i.test(input.value) && input.checkValidity()) {
                    return true;
                } else {
                    this.setFeedback(input, false, 'Неверный формат Email');
                    return false;
                }
            case 'address':
                let first = input.value.split(",")[0];
                if (first.length == 6 && !isNaN(first) && !isNaN(parseFloat(first))) {
                    return true;
                } else {
                    this.setFeedback(input, false, 'Неверный формат адреса. Адрес должен начинаться с почтового индекса');
                    return false;
                }
            case 'sign':
                if (input.classList.contains('confirmed')) {
                    return true;
                } else {
                    
                    this.setFeedback(input, false, 'Необходимо подтвердить подпись');
                    return false;
                }
                break;
        }

        return true;
    }

    validate() {
        let step = this.json.steps[this.step];
        let valid = true;

        for (let i in step.inputs) {
            if (step.inputs[i].visible && step.inputs[i].type != 'button') {
                let input = $(`[name='${step.inputs[i].name}']`, this.el);

                if (!input) {
                    input = $(`[data-name='${step.inputs[i].name}']`, this.el);
                }

                let inputValid = true;
                
                if (step.inputs[i].validation) {
                    if (!this.validateInput(input, step.inputs[i].validation))
                        inputValid = false;
                }
                
                if (step.inputs[i].required && input.value == '' && (step.inputs[i].value == '' || step.inputs[i].value == undefined)) {
                    this.setFeedback(input, false, 'Введите значение');
                    inputValid = false;
                }

                if (!inputValid) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    this.setFeedback(input, true, 'Все в порядке');
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            }
        }
        return valid;
    }

    send() {
        this.saveInputs();
        let fd = new FormData();
        for (let step in this.json.steps) {
            let stepFieldPrefix = this.json.steps[step].fields_prefix;
            for (let input in this.json.steps[step].inputs) {
                if (this.json.steps[step].inputs[input].type == 'sign' || this.json.steps[step].inputs[input].type == 'file') {
                    let fieldName = this.json.steps[step].inputs[input].name;
                    let name = `${stepFieldPrefix}-${fieldName}`;
                    let value = this.json.steps[step].inputs[input].value;

                    fetch(value).then(r => r.blob()).then(blob => {
                        fd.append(name, blob);
                    });

                } else if (this.json.steps[step].inputs[input].type != 'button') {
                    let fieldName = this.json.steps[step].inputs[input].name;
                    if (this.json.steps[step].inputs[input].group && this.json.steps[step].inputs[input].group.split(":").length > 1) {
                        let nm = this.json.steps[step].inputs[input].group.split(":")[1];
                        fieldName = fieldName.replace(nm, "");
                    }
                    let value = this.json.steps[step].inputs[input].value;

                    let name = `${stepFieldPrefix}-${fieldName}`;
                    if (fd.has(name)) {
                        let vl = fd.get(name);
                        fd.delete(name);
                        fd.append(name, `${vl}|${value}`);
                    } else {
                        fd.append(name, value);
                    }    
                }
                
                
            }
        }

        let form = $(`form`, this.el);
        fd.append('_token', $(`[name='_token']`, form).value);

        setTimeout(() => {
            this.btn.innerHTML = `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Загрузка...`;
            fetch(form.action, {
                method: "POST",
                body: fd
            }).then(r => {
                if (r.status == 200) {
                    return r.json();
                }
                
            }).then(r => {

                if (r.to) {
                   window.location.href = r.to; 
                }

                if (r.msg) {
                    this.stepTitle.innerHTML = `Результат`;
                    this.content.innerHTML = r.msg;
                    this.btn.innerText = 'Ещё раз';

                    this.btn.onclick = () => {
                        this.step = 1;
                        this.build();
                        this.btn.innerText = 'Далее';
                    }
                }

                if (r.error) {
                    this.content.insertAdjacentHTML('beforeend', `<p class='text-danger'>Извините, возникла ошибка, мы не можем пока обработать Ваш запрос!<br><br><b>${r.error}</b></p>`);
                    this.btn.innerText = 'Далее';
                }
                

                // this.btn.style.display = "none";
                // this.content.innerHTML = ``;

                // let btn = $(`button`, this.content);
                // btn.onclick = (ev) => {
                //     ev.preventDefault();
                //     this.send();
                // }
                
            });
        }, 300);
    }

    saveInputs() {
        if (this.step > 0) {
            let step = this.json.steps[this.step];
            for (let i in step.inputs) {
                if (step.inputs[i].visible) {
                    let input = $(`[name='${step.inputs[i].name}']`, this.content);
                    
                    if (input) {
                        if (this.json.steps[this.step].inputs[i].type == 'file') {
                            const files = input.files;
                            if (files.length) {
                                this.json.steps[this.step].inputs[i].value = URL.createObjectURL(files[0]);
                            }
                        } else {
                            this.json.steps[this.step].inputs[i].value = input.value;
                        }
                    }
                }
            }    
        }
        
    }

    cloneGroup(groupName) {
        this.saveInputs();
        let inputs = this.json.steps[this.step].inputs;
        let groupInputs = [];
        let additionalName = +new Date();
        let newGroupName = groupName + `:${additionalName}`;

        let lastInput = 0;

        for (let i in inputs) {
            if (inputs[i].visible && inputs[i].group == groupName) {
                let inp = structuredClone(inputs[i]);
                inp.group = newGroupName;
                inp.name = inp.name + `${additionalName}`;
                inp.value = '';
                groupInputs.push(inp);
            }
            lastInput = +i;
        }

        groupInputs.forEach((inp, j) => 
            {
                this.json.steps[this.step].inputs[j + lastInput + 1] = inp;
            }
        );
    }

    removeGroup(groupName) {
        for (let i in this.json.steps[this.step].inputs) {
            if (this.json.steps[this.step].inputs[i].group == groupName) {
                delete this.json.steps[this.step].inputs[i];
            }
        }
    }

    hideGroup(groupName) {
        for (let i in this.json.steps[this.step].inputs) {
            if (this.json.steps[this.step].inputs[i].group) {
                if (this.json.steps[this.step].inputs[i].group.split(':')[0] == groupName) {
                    this.json.steps[this.step].inputs[i].visible = false;
                }    
            }
        }
    }

    showGroup(groupName) {
        for (let i in this.json.steps[this.step].inputs) {
            if (this.json.steps[this.step].inputs[i].group) {
                if (this.json.steps[this.step].inputs[i].group.split(':')[0] == groupName) {
                    this.json.steps[this.step].inputs[i].visible = true;
                }    
            }
        }
    }

    build() {
        if (this.stepsHistory.length == 0 || (this.stepsHistory[-2] != this.step)) {
            this.stepsHistory.push(this.step);    
        }
        
        let step = this.json.steps[this.step];
        this.title.innerHTML = this.json.title;

        this.content.innerHTML = "";

        this.stepTitle.innerHTML = `${step.step_number > 1 ? `<span class="badge bg-primary me-1 calculator-back "><i class="fa-solid fa-arrow-left-long"></i></span>` : ''}<span class="badge bg-primary me-3 ">${step.step_number} / ${this.json.steps_number}</span><span class="fs-5 fw-bold">${step.title}</span>`;
        this.description.innerHTML = `${step.description}`;

        let groupName = "";
        let group = null;
        for (let i in step.inputs) {
            let input = step.inputs[i];
            if (step.inputs[i].visible) {
                if (input.group == null || input.group != groupName) {

                    if (group) {
                        if (groupName && groupName.split(':').length > 1) {
                            let name = groupName;
                            let btn = document.createElement('input');
                            btn.className = "btn btn-primary";
                            btn.value = 'Удалить';
                            btn.type = 'button';
                            btn.onclick = () => {
                                this.removeGroup(name);
                                this.build();
                            };
                            group.appendChild(btn);  
                        }
                        
                        this.content.appendChild(group);
                    }

                    group = document.createElement('div');
                    group.className = `${input.group ? 'border mt-2 p-3 rounded' : 'mt-2'}`;
                    groupName = input.group;
                }
                group.appendChild(this.inputByJson(this.step, i));
            }
        }

        if (groupName && groupName.split(':').length > 1) {
            let name = groupName;
            let btn = document.createElement('input');
            btn.className = "btn btn-primary";
            btn.value = 'Удалить';
            btn.type = 'button';
            btn.onclick = () => {
                this.removeGroup(name);
                this.build();
            };
            group.appendChild(btn);  
        }

        this.content.appendChild(group);

        this.btn.onclick = () => {
            if (this.validate()) {
                if (step.next != null) {
                    this.saveInputs();
                    this.step = step.next;
                    this.build();
                } else {
                    this.send();
                }
                
            }
                window.scrollTo(0, this.title.offsetTop - 200);
        }

        if (step.step_number > 1) {
            let stepBack = $('.calculator-back', this.stepTitle);
            stepBack.onclick = () => {
                this.saveInputs();
                this.stepsHistory.pop();
                this.step = this.stepsHistory.pop();
                this.build();
            }
        }

        jQuery(function($){
            $("[type=tel]").mask("+7 (999) 999-99-99");
         });

         jQuery(function($){
            $("[type=passport]").mask("9999 999999");
         });
    }

    show(ids) {
        ids.forEach(id => {
            let [step, inp] = id.split('.');
            this.json.steps[+step].inputs[+inp].visible = true;
            console.log(this.json.steps[+step].inputs[+inp]);
        })
    }

    hide(ids) {
        ids.forEach(id => {
            let [step, inp] = id.split('.');
            this.json.steps[+step].inputs[+inp].visible = false;
        })
    }

    visible(id) {
        let [step, inp] = id.split('.');
        return this.json.steps[+step].inputs[+inp].visible;
    }

    fill(id, value) {
        let [step, inp] = id.split('.');
        this.json.steps[+step].inputs[+inp].value = value;
        this.updateInput(id);
    }

    updateInput(id) {
        let [step, inp] = id.split('.');
        let name = this.json.steps[+step].inputs[+inp].name;

        if (step == this.step) {
            $(`[name=${name}]`).value = this.json.steps[+step].inputs[+inp].value;
            this.clearValidation($(`[name=${name}]`));    
        }
        
    }

    getCompany(query, callback) {
        dadata.getCompany(query, (company) => callback(company));
    }

    getBank(query, callback) {
        dadata.getBank(query, (bank) => callback(bank));
    }

    getCourt(query, callback) {
        dadata.getCourt(query, (court) => callback(court));
    }

    doAction(input, data, action) {
        eval(action);
    }
}

window.addEventListener('load', () => {
    $$('.calculator').forEach(calc => {

        let applicationId = calc.dataset.application ? `?application=${calc.dataset.application}` : '';

        fetch(`${calc.dataset.addr + applicationId}`, {
            method: "GET"
        }).then(r => r.json()).then(r => {
            let calcEl = new Calculator(calc, r);
        });
    });
});