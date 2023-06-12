import { $, $$ } from "../funcs";


class DaData {
    constructor () {
        this.token = "1689fbde959d4bae73931d54024ec2056fca3b74";
        this.headers = {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + this.token
        };
    }

    request(api, body, callback) {
        fetch(api, {
            method: 'POST',
            mode: 'cors',
            headers: this.headers,
            body: JSON.stringify(body)
        }).then(r => r.json()).then(r => callback(r));
    }

    makeSuggestions(input, suggestions) {
        let group = input.parentNode;
        let datalist = $('.datalist', group);

        if (suggestions.length > 0) {
            datalist.style.display = 'block';
            datalist.innerHTML = "";
            suggestions.forEach(sug => {
                let item = document.createElement('div');
                item.className = 'datalist-item py-1 px-3';
                item.innerHTML = sug['text'];
                item.onmousedown = () => {
                    input.value = sug['value'];
                }

                datalist.appendChild(item);
            });
        } else {
            datalist.style.display = 'none';
        }
    }

    suggest(mode, input) {
        let api = '';
        switch (mode) {
            case 'fio':
                api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/fio";
                this.request(api, {query: input.value}, r => {
                    let array = r.suggestions.map(sug => 
                        { return {value: sug.value, 
                        text: sug.value} });
                    this.makeSuggestions(input, array);
                });
                break;
            
            case 'bik':
                api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
                this.request(api, {query: input.value}, r => {
                    let array = r.suggestions.map(sug => 
                        { return {value: sug.data.bic, 
                        text: sug.data.bic} });
                    this.makeSuggestions(input, array);
                });
                break;
            
            case 'bank':
                api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
                this.request(api, {query: input.value}, r => {
                    let array = r.suggestions.map(sug => 
                        { return {value: sug.value, 
                        text: sug.value} });
                    this.makeSuggestions(input, array);
                });
                break;
            
            case 'inn':
                api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party";
                this.request(api, {query: input.value}, r => {
                    let array = r.suggestions.map(sug => 
                        { return {value: sug.data.inn, 
                        text: sug.value} });
                    this.makeSuggestions(input, array);
                });
                break;
            
            case 'company_name':
                api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party";
                this.request(api, {query: input.value}, r => {
                    let array = r.suggestions.map(sug => 
                        { return {value: sug.data.name.full_with_opf, 
                        text: sug.data.name.full_with_opf} });
                    this.makeSuggestions(input, array);
                });
                break;
            
            case 'address':
                api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address";
                this.request(api, {query: input.value}, r => {
                    let array = r.suggestions.filter(sug => {
                        return sug.data.postal_code ? true : false;
                    }).filter(sug => {
                        
                        return sug.unrestricted_value.indexOf('д ') > -1 || sug.unrestricted_value.indexOf('кв ') > -1 || sug.unrestricted_value.indexOf('стр ') > -1;
                    }).map(sug => 
                        { return {value: sug.unrestricted_value, 
                        text: sug.unrestricted_value} });
                    this.makeSuggestions(input, array);
                });
                break;

            case 'court':
                api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/region_court";
                this.request(api, {query: input.value}, r => {
                    let array = r.suggestions.map(sug => 
                        { return {value: sug.unrestricted_value, 
                        text: sug.unrestricted_value} });
                    this.makeSuggestions(input, array);
                });
                break;
        }
        
    }

    getCompany(query, callback) {
        let api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party";
        this.request(api, {query: query}, r => {
            if (r.suggestions) {
                callback(r.suggestions[0]);
            } else {
                callback(null);
            }
            
        });
    }

    getCourt(query, callback) {
        let api = "https://иск.онлайн/мирсуд";
        let fd = new FormData();
        fd.append('addr', query);
        fd.append('_token', $(`[name='_token']`).value);
        fetch(api, {
            method: "POST",
            body: fd
        }).then(r => r.json()).then(r => {
            if (r) {
                callback(r);
            }
        });
    }

    getBank(query, callback) {
        let api = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
        this.request(api, {query: query}, r => {
            if (r.suggestions) {
                callback(r.suggestions[0]);
            } else {
                callback(null);
            }
            
        });
    }
}

const dadata = new DaData();

export default dadata;