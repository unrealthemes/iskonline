import { $, $$ } from "../funcs";
import Sortable from 'sortablejs';

class DocumentConstructor {
    constructor (el) {
        this.el = el;

        // Область с готовыми блоками
        this.toolsArea = $('.document-area-tools', this.el);

        // Область работы
        this.area = $('.document-area-area', this.el);

        // Мусорка
        this.trash = $('.document-area-trash', this.el);

        this.area.innerHTML = "";

        // JSON
        this.json = [
            
        ];

        // Поля ввода и группы
        this.fields = $('#form-inputs', this.el).value.split(';');
        this.groups = $('#form-groups', this.el).value.split(';');

        // Поле для сохранения
        this.areasInput = $('[name="areas"]', this.el);

        this.json = JSON.parse(this.areasInput.value);

        // Обработка
        this.handle();
    }

    save() {
        this.json = this.parseStructure();

        console.log(this.json);
                    
        this.areasInput.value = JSON.stringify(this.json);
    }

    rerender() {
        this.save();
        this.handle();
    }

    handle() {

        this.placeTools();
        this.render();
        
        // Очистка мусорки
        $$('li', this.trash).forEach(li => li.remove());

        // Подключение всех зон
        [...$$('.document-area', this.area), this.area, this.trash].forEach(ul => {
            new Sortable(ul, {
                animation: 150,
                group: "area",
                onEnd: _ => {
                    this.rerender();
                }
            });
        });

        // Подключение инструментов
        new Sortable(this.toolsArea, {
            animation: 150,
            group: {
                name: 'area',
                put: false,
                pull: 'clone',
            },
            onEnd: _ => {
                this.rerender();
            },
            sort: false,
        });
    }

    renderBlock(area, json) {
        let tp = this.getTools()[json.type];

        let li = document.createElement('li');
        li.className = `document-block ${tp.color}`;
        li.dataset.type = json.type;
        
        let label = document.createElement('div');
        label.className = `document-block-label`;
        label.innerHTML = tp.label(json.options);
        li.appendChild(label);

        let inner = document.createElement('div');
        inner.className = `document-block-inner`;
        li.appendChild(inner);

        if (tp.innerType == "area") {
            let ul = document.createElement('ul');
            ul.className = "document-area";
            
            inner.appendChild(ul);

            json.area.forEach(el => {
                this.renderBlock(ul, el);
            });

        } else if (tp.innerType == "text") {
            let p = document.createElement('p');
            p.contentEditable = true;
            p.spellcheck = false;
            p.innerHTML = json.area;

            inner.appendChild(p);

            p.oninput = _ => {
                this.save();
            }

        } else if (tp.innerType == "paragraph") {
            let p = document.createElement('p');
            p.contentEditable = true;
            p.spellcheck = false;
            p.className = "indent";
            p.innerHTML = json.area;

            inner.appendChild(p);

            p.oninput = _ => {
                this.save();
            }
        }


        area.appendChild(li);
    }

    getTools() {
        return {
            "text": {
                color: "violet",
                label: options => "Текст",
                innerType: "text",
                area: "Некоторый текст",
            },

            "paragraph": {
                color: "violet",
                label: options => "С новой строки",
                innerType: "paragraph",
                area: "Позволяет вставить некоторый текст с новой строки в документ (не абзац)",
            },

            "if": {
                color: "orange",
                label: options => `Если значение ${sel("input", options, this.fields.map(el => [el, el]))} равно ${inp("value", options)}`,
                innerType: "area",
                area: [],
            },

            "foreach": {
                color: "green",
                label: options => `Для значений группы ${sel("group", options, this.groups.map(el => [el, el]))}`,
                innerType: "area",
                area: [],
            },
        };
    }
    
    placeTools() {
        Array.from(this.toolsArea.children).forEach(area => area.remove());

        let blocksTypes = this.getTools();
        let blocks = [];

        for (let key in blocksTypes) {
            blocks.push({...blocksTypes[key], type: key, options: {}});
        }

        blocks.forEach(block => this.renderBlock(this.toolsArea, block));
    }

    render() {
        Array.from(this.area.children).forEach(area => area.remove());

        this.json.forEach(block => {
            this.renderBlock(this.area, block);
        });
    }

    parseStructure(area=this.area) {
        let lis = Array.from($$('li.document-block', area)).filter(el => el.parentNode == area);
        let json = [];
        let types = this.getTools();
        lis.forEach(li => {
            let tp = types[li.dataset.type];

            let label = Array.from($$('.document-block-label', li)).filter(el => el.parentNode == li)[0];
            let inner = Array.from($$('.document-block-inner', li)).filter(el => el.parentNode == li)[0];

            let elJson = {
                type: li.dataset.type,
                options: {},
                area: tp.innerType == "area" ? [] : $('p', inner).innerHTML
            };

            $$('[data-value]', label).forEach(value => {
                let val = value.value;
                if (value.dataset.type == 'span') {
                    val = value.innerHTML;
                }

                elJson.options[value.dataset.value] = val;
            });

            if (tp.innerType == "area") {
                let ul = inner.children[0];

                elJson.area = this.parseStructure(ul);
            }

            json.push(elJson);
        });

        return json;
    }
}

function inp(name, options) {
    return `<span data-value='${name}' data-type="span" contenteditable="true" spell-check="false">${options[name] ? options[name] : ""}</span>`;
}

function sel(name, options, opts) {
    let optsHtml = ``;
    opts.forEach(opt => {
        optsHtml += `<option value="${opt[0]}" ${opt[0] == options[name] ? "selected" : ""}>${opt[1]}</option>`;
    });

    return `<select data-value="${name}" data-type="select">${optsHtml}</select>`;
}

export default DocumentConstructor;