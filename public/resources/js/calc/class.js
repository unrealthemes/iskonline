// var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party";
// var token = "1689fbde959d4bae73931d54024ec2056fca3b74";
// var query = "7725806930";

// var options = {
//     method: "POST",
//     mode: "cors",
//     headers: {
//         "Content-Type": "application/json",
//         "Accept": "application/json",
//         "Authorization": "Token " + token
//     },
//     body: JSON.stringify({query: query})
// }

// fetch(url, options)
// .then(response => response.text())
// .then(result => console.log(result))
// .catch(error => console.log("error", error));

import { $, $$ } from "../funcs";
import dadata from "./api";

class Calculator {
    constructor(el, json) {
        this.el = el;
        this.json = json;

        this.title = $('.calculator-title', el);
        this.stepTitle = $('.calculator-step-title', el);
        this.content = $('.calculator-content', el);
        this.btn = $('.calculator-btn', el);
        this.step = 1;

        this.stepsHistory = [];

        this.build();
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
        group.className = 'form-floating mb-3';

        let input = '';
        // Выбор типов полей
        if (json.type == 'textarea') {
            input = `
            <textarea 
                name="${json.name}" 
                id="${json.name}" 
                cols="30" 
                rows="6" 
                class="form-control"
                placeholder="${json.label}"
            >${json.value}</textarea>
            `;
        } else if (json.type == 'select') {
            input = `
            <select
                name="${json.name}" 
                id="${json.name}" 
                class="form-control"
                placeholder="${json.label}" 
            >
                ${ json.options.map(option => `<option value="${option.id}" ${option.id == json.value ? 'selected' : ''}>${option.text}</option>`).join("") }
            </select>
            `;
        } else {
            input = `<input 
                type="${ json.type }" 
                ${ json.multiple ? 'multiple' : '' } 
                name="${json.name}" 
                id="${json.name}" 
                ${ json.value ? `value='${json.value}'` : '' } 
                placeholder="${json.label}" 
                class="form-control"
            >`;
        }

        // Подпись
        let label = `<label for="${json.name}">${json.label}</label>`;

        // Сообщение об ошибке
        let validationFeedback = `<div class="feedback valid-feedback"></div>`;

        // Подсказки
        let datalist = '';
        if (json.suggestion) {
            datalist = `<div id='${json.name}-datalist' style="display: none;" class='datalist shadow rounded overflow-hidden'>
            </div>`;
        }

        // Добавление компонентов в группу
        group.innerHTML = input + label + datalist + validationFeedback;

        // Работа с полем
        input = $('.form-control', group);
        input.addEventListener('input', () => {
            this.json.steps[step].inputs[inp].value = input.value;
            this.clearValidation(input);
        });

        if (json.disabled) {
            input.disabled = true;
        }

        // Контроль ввода
        if (json.type == 'tel') {
            input.addEventListener('focus', (e) => {
            });
            input.addEventListener('keypress', (e) => {
                // Отменяем ввод не цифр
                if(/\d/.test(e.key) || (e.key == '+' && input.value == '')) {

                } else {
                    e.preventDefault();
                }
                    
            });
        }
        
        // Привязка подсказок
        if (json.suggestion) {
            input.setAttribute('data-list', `${json.name}-datalist`);
            input.addEventListener('input', () => {
                dadata.suggest(json.suggestion, input);
            });
            input.addEventListener('blur', () => {
                setTimeout(() => $(`#${json.name}-datalist`, group).style.display = "none", 200);
            })
        }

        // Привязка событий
        if (json.events) {
            for (let event in json.events) {
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
                if (input.value.startsWith('+7') && input.value.length == 12)
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
                if (/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i.test(input.value)) {
                    return true;
                } else {
                    this.setFeedback(input, false, 'Неверный формат Email');
                    return false;
                }
        }

        return true;
    }

    validate() {
        let step = this.json.steps[this.step];
        let valid = true;
        for (let i in step.inputs) {
            if (step.inputs[i].visible) {
                let input = $(`[name='${step.inputs[i].name}']`, this.el);
                let inputValid = true;
                
                if (step.inputs[i].validation) {
                    if (!this.validateInput(input, step.inputs[i].validation))
                        inputValid = false;
                }
                if (step.inputs[i].required && input.value == '') {
                    this.setFeedback(input, false, 'Введите значение');
                    inputValid = false;
                }

                if (!inputValid) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    this.setFeedback(input, true, 'Все в порядке');
                    input.classList.add('is-valid');
                }
            }
        }
        return valid;
    }

    send() {
        let fd = new FormData();
        for (let step in this.json.steps) {
            let stepFieldPrefix = this.json.steps[step].fieldPrefix;
            for (let input in this.json.steps[step].inputs) {
                let fieldName = this.json.steps[step].inputs[input].name;
                let value = this.json.steps[step].inputs[input].value;
                fd.append(`${stepFieldPrefix}-${fieldName}`, value);
            }
        }

        let form = $(`form`, this.el);
        fd.append('_token', $(`[name='_token']`, form).value);
        fetch(form.action, {
            method: "POST",
            body: fd
        }).then(r => r.json()).then(r => {
            fetch(`./../documents/activate/${r.document_id}/${r.code}`);

            window.location.href = '/docsgen/account'; 

            this.btn.style.display = "none";
            this.content.innerHTML = `
                <div class='text-center mb-2'><button role='button' class='btn btn-success btn-lg' >Сформировать еще раз</button></div>
                <div class='text-center'><a role='button' class='btn btn-primary btn-lg' href='./../documents/${r.document_id}/${r.code}'>Загрузить</a></div>
            `;
            this.stepTitle.innerHTML = `Загрузка документа`;

            let btn = $(`button`, this.content);
            btn.onclick = (ev) => {
                ev.preventDefault();
                this.send();
            }
            
        })
    }

    saveInputs() {
        let step = this.json.steps[this.step];
        for (let i in step.inputs) {
            if (step.inputs[i].visible) {
                let input = $(`[name='${step.inputs[i].name}']`, this.content);
                this.json.steps[this.step].inputs[i].value = input.value;
            }
        }
    }

    build() {
        this.stepsHistory.push(this.step);
        let step = this.json.steps[this.step];
        this.title.innerHTML = this.json.title;

        this.content.innerHTML = "";

        this.stepTitle.innerHTML = `${step.stepNumber > 1 ? `<span class="badge bg-primary me-1 calculator-back "><i class="bi bi-arrow-left"></i></span>` : ''}<span class="badge bg-primary me-3">${step.stepNumber} / ${this.json.stepsCount}</span> ${step.title}`;

        for (let i in step.inputs) {
            let input = step.inputs[i];
            if (step.inputs[i].visible) {
                this.content.appendChild(this.inputByJson(this.step, i));
            }
        }

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
        }

        if (step.stepNumber > 1) {
            let stepBack = $('.calculator-back', this.stepTitle);
            stepBack.onclick = () => {
                this.saveInputs();
                this.stepsHistory.pop();
                this.step = this.stepsHistory.pop();
                this.build();
            }
        }
    }

    show(ids) {
        ids.forEach(id => {
            let [step, inp] = id.split('.');
            this.json.steps[+step].inputs[+inp].visible = true;
        })
    }

    hide(ids) {
        ids.forEach(id => {
            let [step, inp] = id.split('.');
            this.json.steps[+step].inputs[+inp].visible = false;
        })
    }

    fill(id, value) {
        let [step, inp] = id.split('.');
        this.json.steps[+step].inputs[+inp].value = value;
        this.updateInput(id);
    }

    updateInput(id) {
        let [step, inp] = id.split('.');
        let name = this.json.steps[+step].inputs[+inp].name;

        $(`[name=${name}]`).value = this.json.steps[+step].inputs[+inp].value;
        this.clearValidation($(`[name=${name}]`));
    }

    getCompany(query, callback) {
        dadata.getCompany(query, (company) => callback(company));
    }

    doAction(input, data, action) {
        eval(action);
    }
}

