export function checkDoveer() {
    let searchBtn = document.querySelector('#searchbtn');
    let captchaForm = document.querySelector('#captchaform');
    let code = document.querySelector('#code');
    let captcha = document.querySelector('#captcha');

    document.querySelector('#type').addEventListener('change', function () {
        let type = document.querySelector('#type').value;
        console.log(type);
        let consulBlock = document.querySelector('#inputs-consul');
        let regionBlock = document.querySelector('#inputs-region');
        let notBlock = document.querySelector('#inputs-not');
        if (type == 'not') {
            notBlock.style.display = 'block';
            consulBlock.style.display = 'none';
            regionBlock.style.display = 'none';
            return true;
        }
        if (type == 'RKU') {
            consulBlock.style.display = 'block';
            regionBlock.style.display = 'none';
            notBlock.style.display = 'none';
            return true;
        }
        if (type == 'DLOMS') {
            consulBlock.style.display = 'none';
            notBlock.style.display = 'none';
            regionBlock.style.display = 'block';
            return true;
        }
    })


    //Функция для AJAX
    function sendRequest(method, url, data) {
        return fetch(url, {
            method: method,
            body: data
        })
    }
    //Вывод ошибки
    function echoError(error) {
        let errorBlock = document.querySelector('#error');
        errorBlock.innerText = ' ';
        errorBlock.innerText = error;
        setTimeout(function () {
            errorBlock.innerText = ' ';
        }, 4000)
        echoResult("");
    }

    function echoResult(result) {
        let resultBlock = document.querySelector('#result');
        resultBlock.innerText = ' ';
        resultBlock.innerText = result;
    }

    function clearCaptchaForm() {
        code.value = " ";
        captcha.value = " ";
    }
    ///////////////////////////////Функции работы с капчей////////////////////////////////////////
    //Вывод капчи
    function AppendCaptcha(data) {
        let img = document.querySelector('#captchaimg');
        img.src = data['result']['captcha'];
        setTimeout(function () {
            img.contentWindow.location.reload(true)
            captchaForm.style.display = 'block';
        }, 1000)
        code.value = data['result']['code'];
    }
    document.querySelector('#captchabtn').onclick = () => {
        echoResult('Ожидайте...')
        captchaForm.style.display = 'none';
        searchBtn.style.display = 'block';
        let data = new FormData();
        data.append('captcha', captcha.value);
        data.append('code', code.value);
        let request = sendRequest('POST', "api/doveer/result", data)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                clearCaptchaForm();
                if (data['result']['error'] != undefined) {
                    echoResult(data['result']['error']);
                    return false;
                }
                echoResult(data['result']);
            });
    }
    ///////////////////////////////Функции работы с капчей////////////////////////////////////////
    ///////////////////////////////Поиск по нотариусам////////////////////////////////////////
    //функция запускающия поиск 
    searchBtn.onclick = () => {
        echoResult('Подгружаю капчу...')
        let forma = document.querySelector('#sarchdoveer');
        let data = new FormData(forma);
        let request = sendRequest('POST', "/doveer/captcha", data)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                if (data['result']['error'] == undefined) {
                    searchBtn.style.display = 'none';
                    AppendCaptcha(data);
                    echoResult('Введите капчу')
                } else {
                    echoError(data['result']['error']);
                }
            });

    }
    //Поиск нотариуса
    document.getElementsByName('notName')[0].oninput = () => {
        let notName = document.getElementsByName('notName')[0];
        // if (notName.length > 2) {
        if (notName.value.length = 5 && notName.value.length > 7) {
            echoResult('Начинаю поиск нотариусов')
            console.log(notName.value,);
            searchNot(notName.value);
        }
    }
    //Отправка запроса на поиск нотариуса
    function searchNot(name) {
        let request = sendRequest('GET', "/doveer/searchNot/" + name)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                AppendNot(data);
            });
    }
    //Вывод нотариусов
    function AppendNot(data) {
        let notList = document.querySelector('#not-list');
        notList.style.display = 'block';
        notList.innerHTML = " ";
        for (key in data) {
            let name = data[key][0]['fullName'];
            notList.appendChild(getNotBlock(name));
        }
        echoResult(' ')
    }
    //Блок для 
    function getNotBlock(name) {
        let row = document.createElement('div');
        row.setAttribute('class', 'row');
        let col = document.createElement('div')
        row.setAttribute('class', 'col-12 bg-white"');
        let span = document.createElement('span');
        span.setAttribute('class', 'm-5')
        span.innerText = name;
        row.appendChild(col);
        col.appendChild(span);
        row.onclick = () => {
            let input = document.getElementsByName('notName')[0];
            input.value = row.innerText;
            let notList = document.querySelector('#not-list');
            notList.style.display = 'none';
            return false;
        }
        return row;
    }
}