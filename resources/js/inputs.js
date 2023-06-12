import dadata from "./calc/api";
import { $, $$ } from "./funcs";


window.addEventListener('load', ev => {

    // Телефоны
    $$("input[type='tel']").forEach(input => {
        input.addEventListener('keypress', (e) => {
            // Отменяем ввод не цифр
            if((/\d/.test(e.key) || (e.key == '+' && input.value == '')) && input.value.length < 12) {

            } else {
                e.preventDefault();
            }
                
        });

    });


    // Отправка форм
    $$('form.no-send').forEach(form => {
        form.onsubmit = ev => {
            ev.preventDefault();

            let fd = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: fd
            }).then(r => r.json()).then(r => {
                if (r.ok) {
                    window.location.href = r.to;
                } else {
                    $('.errors', form).innerHTML = r.errors.map(error => `<div class='alert alert-danger mt-4'>${error}</div>`).join('');
                }
            });
        }
    });


    // Повторная отправка кода
    $$('.repeat-code').forEach(input => {
        input.classList.remove('d-block');
        input.classList.add('d-none');
        let timer = 120;

        const timerAction = () => {
            input.classList.add('d-block');
            input.classList.remove('d-none');
            if (timer > 0) {
                $('span', input.parentNode).innerHTML = `Отправить повторно можно будет через ${timer} сек.`;
                input.disabled = true;
                timer --;

                setTimeout(() => timerAction(), 1000);
            } else {
                $('span', input.parentNode).innerHTML = ``;
                input.disabled = false;
            }
        }

        const sendRequest = () => {
            let fd = new FormData(input.parentNode.parentNode);
            fetch('./повторное-подтверждение', {
                method: 'POST',
                body: fd
            }).then(r => r.json()).then(r => {
                if (r.ok) {
                    timer = r.time;
                    setTimeout(() => timerAction(), 1000);
                } else {
                    if (r.error == 'too-much-time') {
                        window.location.href = './вход';
                    } else {
                        timer = r.time;
                        setTimeout(() => timerAction(), 1000);
                    }
                }
                input.innerHTML = ``;
            });
        }
        
        sendRequest();

        input.addEventListener('click', ev => {
            sendRequest();
        });
    });

    // Подсказки
    $$('[data-suggestions]').forEach(input => {
        if (input.dataset.suggestions != '') {
            input.addEventListener('input', () => {
                console.log(909);
                dadata.suggest(input.dataset.suggestions, input);
            });

            input.addEventListener('blur', () => {
                setTimeout(() => $(`.datalist`, input.parentNode).style.display = "none", 200);
            })
        }
    });
});