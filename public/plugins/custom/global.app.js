function domReady(fn) {
    if (document.readyState != 'loading'){
        fn();
    } else if (document.addEventListener) {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        document.attachEvent('onreadystatechange', function() {
        if (document.readyState != 'loading')
            fn();
        });
    }
}

function addListenToEvent(elementSelector, eventName, handler) {
    document.addEventListener(eventName, function(e) {
        for (var target = e.target; target && target != this; target = target.parentNode) {
            if (target.matches(elementSelector)) {
                handler.call(target, e);
                break;
            }
        }
    }, false);
}

function drawError(parentElm, validators) {
    for (const keyName in validators) {
        if (validators.hasOwnProperty(keyName)) {
            const value = validators[keyName][0];

            parentElm.querySelector(`[name="${keyName}"]`).classList.add('is-invalid');
            parentElm.querySelector(`[name="${keyName}"]`).closest('.form-group').querySelector('.invalid-feedback').innerHTML = `${value}`;
        }
    }
}

function eraseErrorInit(params) {
    addListenToEvent('input, textarea', 'change', (e) => {
        e.target.classList.remove('is-invalid');
        e.target.closest('.form-group').querySelector('.invalid-feedback').innerHTML = ``;
    });

    $(document).on('change', 'select', (e) => {
        e.target.classList.remove('is-invalid');
        e.target.closest('.form-group').querySelector('.invalid-feedback').innerHTML = ``;
    })
}

function swalAlert(content, type){
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: type,
        title: content,
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
}

function swalConfirm(text){
    return new Promise((resolve, reject) => {
        Swal.fire({
            customClass: {
                confirmButton: 'btn btn-info',
                cancelButton: 'btn btn-default'
            },
            buttonsStyling: false,
            focusCancel: true,
            position: 'center',
            icon: 'question',
            text: `Apakah anda yakin untuk ${text}?`,
            showCancelButton: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal'
        })
        .then((result) => {
            if (result.value) {
                resolve();
            }
        });
    });
}

function simulateEvent(elm, eventName) {
    let evt = new MouseEvent(eventName, {
        bubbles: true,
        cancelable: true,
        view: window
    });
    !elm.dispatchEvent(evt);
}

function select2DatatableInit() {
    for (const elm of document.querySelectorAll('.dataTables_length select')) {
        $(elm).select2({
            minimumResultsForSearch: Infinity
        });
    }
    for (const elm of document.querySelectorAll('.dataTables_length span.select2')) {
        elm.style.width = '5rem';
    }

}

function getIndoDate(val){
    let date = new Date(val).toDateString();
    let date_split = date.split(' ');
    return `${date_split[2]} ${date_split[1]} ${date_split[3]}`;
}

function getIsoNumberWithSeparator(isoNumber){
    return isoNumber.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

export {
    domReady,
    addListenToEvent,
    drawError,
    eraseErrorInit,
    swalAlert,
    swalConfirm,
    simulateEvent,
    select2DatatableInit,
    getIndoDate,
    getIsoNumberWithSeparator,
}
