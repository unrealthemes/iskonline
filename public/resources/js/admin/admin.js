import { $, $$ } from "../funcs";
import {confirm2, success2} from "./alerts";

// Привязка подтверждения к ссылкам
$$('a.confirm').forEach(a => {
    a.onclick = ev => {
        ev.preventDefault();

        confirm2(() => {
            window.location.href = a.href;
        }, a.dataset.confirmText ? a.dataset.confirmText : "");
    }
});

// Активация конструктора форм
import FormConstructor from './formConstructor.js';
let elements = $$('.form-constructor');

elements.forEach(el => {
    new FormConstructor(el);
});

// Активация конструктора документа
import DocumentConstructor from "./documentAreaConstructor";
elements = $$('.document-constructor');

elements.forEach(el => {
    new DocumentConstructor(el);
});