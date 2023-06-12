import { $, $$ } from "../funcs";
import Sortable from 'sortablejs';

class LogicConstructor {
    constructor (el, jsonAdapter, inp) {
        this.el = el;
        this.jsonAdapter = jsonAdapter;
        this.inp = inp;

        // Область с готовыми блоками
        this.blocksArea = $('.blocks-area', this.el);

        // Область работы
        this.area = $('.logic-area', this.el);

        // Мусорка
        this.trash = $('.blocks-trash', this.el);

        this.area.innerHTML = "";

        // Отрисовка блоков
        this.placeBlocksTemplates();
        this.placeBlocks();

        this.json = inp.events;
        this.placeInitBlocks();
    }

    renderBlock(area, json) {
        let tp = this.getBlocksJson()[json.type];

        let li = document.createElement('li');
        li.className = `logic-block ${tp.color}`;
        li.dataset.type = json.type;
        li.dataset.category = tp.category ;
        
        tp.sections.forEach((section, i) => {
            let label = document.createElement('div');
            label.className = `logic-block-label`;
            label.innerHTML = section.html(json.options);
            li.appendChild(label);

            if (section.area) {
                let ul = document.createElement('ul');
                ul.className = "logic-area";
                
                li.appendChild(ul);

                if (json.areas && json.areas[i]) {
                    json.areas[i].forEach(el => {
                        this.renderBlock(ul, el);
                    });     
                }
            }

        });

        area.appendChild(li);
    }

    placeBlocksTemplates () {

        let blocks = this.getBlocksJson();
        this.blocksArea.innerHTML = '';

        for (let block in blocks) {
            this.renderBlock(this.blocksArea, {
                type: block,
                options: {},
            });
        }

        new Sortable(this.blocksArea, {
            animation: 150,
            group: {
                name: 'programm',
                put: false,
                pull: 'clone',
            },
            onEnd: _ => {
                this.placeBlocks();
            },
            sort: false,
        });
    }

    placeInitBlocks() {
        for (let block of this.json) {
            this.renderBlock(this.area, block);
        }
    }

    placeBlocks() {

        [...$$('.logic-area', this.area), this.area, this.trash].forEach(logicArea => {
            new Sortable(logicArea, {
                animation: 150,
                group: {
                    name: 'programm',
                },
                onEnd: _ => {
                    this.placeBlocks();
                }
            });  
        });
        $$('li', this.trash).forEach(li => li.remove());
    }

    parseLogic(area=this.area) {
        let lis = Array.from($$('li.logic-block', area)).filter(el => el.parentNode == area);
        let json = [];
        lis.forEach(li => {
            let labels = Array.from($$('.logic-block-label', li)).filter(el => el.parentNode == li);
            let areas = Array.from($$('.logic-area', li)).filter(el => el.parentNode == li);

            let elJson = {
                category: li.dataset.category,
                type: li.dataset.type,
                options: {},
                areas: []
            };

            labels.forEach(lb => {
                $$('[data-value]', lb).forEach(value => {
                    let val = value.value;
                    if (value.dataset.type == 'span') {
                        val = value.innerHTML;
                    }

                    elJson.options[value.dataset.value] = val;
                });
            });

            areas.forEach(a => elJson.areas.push(this.parseLogic(a)))

            json.push(elJson);
        });

        return json;
    }

    getBlocksJson() {
        let els = this.jsonAdapter.getElementsNames().map(el => [el, el]);
        return {

            // ===== СОБЫТИЯ =====
            // При появлении
            "init": {
                category: "event",
                color: "green",
                sections: [
                    {
                        html: options => `При появлении`,
                        area: true,
                    },
                ]
            },

            // При изменении значения
            "change": {
                category: "event",
                color: "green",
                sections: [
                    {
                        html: options => `При изменении значения`,
                        area: true,
                    },
                ]
            },

            // При нажатии кнопки "Далее"
            "next": {
                category: "event",
                color: "green",
                sections: [
                    {
                        html: options => `При переходе далее`,
                        area: true,
                    },
                ]
            },

            // ===== УСЛОВНЫЕ ОПЕРАТОРЫ =====
            // Если значение равно
            "if-value": {
                category: "cond",
                color: "orange",
                sections: [
                    {
                        html: options => `Если значение равно ${inp('val', options)}, то`,
                        area: true,
                    },
                ]
            },

            // Если значение равно / иначе
            "if-value-else": {
                category: "cond",
                color: "orange",
                sections: [
                    {
                        html: options => `Если значение равно ${inp('val', options)}, то`,
                        area: true,
                    },
                    {
                        html: options => `Иначе`,
                        area: true,
                    },
                ]
            },

            // ===== КОМАНДЫ =====
            // Показать элемент
            "show": {
                category: "action",
                color: "violet",
                sections: [
                    {
                        html: options => `Показать ${sel('field', options, els)}`,
                    },
                ]
            },

            // Скрыть элемент
            "hide": {
                category: "action",
                color: "violet",
                sections: [
                    {
                        html: options => `Скрыть ${sel('field', options, els)}`,
                    },
                ]
            },

            // Вывести алерт
            "alert": {
                category: "action",
                color: "violet",
                sections: [
                    {
                        html: options => `Показать уведомление "${inp('text', options)}"`,
                    },
                ]
            },

            // ===== СЛОЖНЫЕ КОМАНДЫ =====
            
            // Заполнить ИНН, Адрес по названию компании
            "company-by-name" : {
                category: "action",
                color: "violet",
                sections: [
                    {
                        html: options => `Данные компании по названию`,
                    },
                    {
                        html: options => `Вставить ИНН в ${sel('inn', options, els)}`,
                    },
                    {
                        html: options => `Вставить Адрес в ${sel('addr', options, els)}`,
                    },
                    
                ]
            },

            // Заполнить Название, Адрес по ИНН компании
            "company-by-inn" : {
                category: "action",
                color: "violet",
                sections: [
                    {
                        html: options => `Данные компании по инн`,
                    },
                    {
                        html: options => `Вставить название в ${sel('name', options, els)}`,
                    },
                    {
                        html: options => `Вставить Адрес в ${sel('addr', options, els)}`,
                    },
                    
                ]
            },

            // Данные банка по БИК
            "bank-by-bik": {
                category: "action",
                color: "violet",
                sections: [
                    {
                        html: options => `Данные банка по БИК`,
                    },
                    {
                        html: options => `Вставить название в ${sel('name', options, els)}`,
                    },
                    {
                        html: options => `Вставить кор. счёт в ${sel('corr', options, els)}`,
                    },
                    
                ]
            },

            // Данные банка по Наименованию
            "bank-by-name": {
                category: "action",
                color: "violet",
                sections: [
                    {
                        html: options => `Данные банка по названию`,
                    },
                    {
                        html: options => `Вставить БИК в ${sel('bik', options, els)}`,
                    },
                    {
                        html: options => `Вставить кор. счёт в ${sel('corr', options, els)}`,
                    },
                    
                ]
            },

            // ===== ВАЛИДАЦИЯ =====

            // Вывести ошибку
            "error": {
                category: "action",
                color: "pink",
                sections: [
                    {
                        html: options => `Ошибка "${inp('error', options)}"`,
                    },
                ]
            },
        };
    }
}

function inp(name, options) {
    return `<span data-value='${name}' data-type="span" contenteditable="true">${options[name] ? options[name] : ""}</span>`;
}

function sel(name, options, opts) {
    let optsHtml = ``;
    opts.forEach(opt => {
        optsHtml += `<option value="${opt[0]}" ${opt[0] == options[name] ? "selected" : ""}>${opt[1]}</option>`;
    });

    return `<select data-value="${name}" data-type="select">${optsHtml}</select>`;
}

export default LogicConstructor;