let Sketchpad = require('responsive-sketchpad');

let el = document.querySelector('.pad');

function padInit(el, val=false) {
    var pad = new Sketchpad(el, {
        line: {
            color: '#f44335',
            size: 4
        },
        width: 400,
        height: 300
    });

    // Set line size
    // pad.setLineSize(10);
    pad.setLineColor("#122faa");

    let btnClear = el.parentNode.querySelector('.btn-clear');

    if (btnClear) {
        btnClear.onclick = (ev) => {
            ev.preventDefault();
            pad.clear();
        }    
    }
    

    if (val) {
        pad.setReadOnly(true);
    }

    return pad;
}

export default padInit;