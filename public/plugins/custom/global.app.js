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

export { 
    domReady,
    addListenToEvent,
    drawError,
    eraseErrorInit,
    swalAlert,
}
