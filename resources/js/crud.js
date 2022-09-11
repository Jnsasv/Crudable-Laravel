// El funcionamiento de Crud depende de el uso de Axios implementado en app.js

// const { default: axios } = require("axios")

createRecord = () => {
    axios.get(`${model}/create`, {
        responseType: 'text'
    })
        .then(function (response) {
            document.getElementById('render-section').innerHTML = response.data;
            document.getElementById('crud-form').addEventListener('submit', handleSubmit);
        });
}

editRecord = (id) => {
    axios.get(`${model}/edit/${id}`, {
        responseType: 'text'
    })
        .then(function (response) {
            document.getElementById('render-section').innerHTML = response.data;
            document.getElementById('crud-form').addEventListener('submit', handleSubmit);
        });
}

confirmDelete = (id) => {
    axios.get(`${model}/delete/${id}`, {
        responseType: 'text'
    })
        .then(function (response) {
            document.getElementById('render-section').innerHTML = response.data;
            document.getElementById('crud-form').addEventListener('submit', handleSubmit);
        });
}

confirmReActivate = (id) => {
    axios.get(`${model}/reactivate/${id}`, {
        responseType: 'text'
    })
        .then(function (response) {
            document.getElementById('render-section').innerHTML = response.data;
            document.getElementById('crud-form').addEventListener('submit', handleSubmit);
        });
}

handleSubmit = (event) => {
    event.preventDefault();

    cleanErrors();
    const data = new FormData(event.target);
    const values = Object.fromEntries(data.entries());

    switch (values['_method']) {
        case 'put':
            submitUpdate(values);
            break;
        case 'delete':
            submitDestroy(values);
            break;
        case 'activate':
            submitActivate(values);
            break;
        default:
            if (values.reactivate !== undefined)
                submitActivate(values);
            else
                submitStore(values);
            break;
    }
}

submitStore = (values) => {
    url = `${model}/store`;
    axios.post(url, values)
        .then((response) => {
            showMessages({ title: 'Registro Creado', info: "Se ha Creado correctamente el Registro", kind: "success" });
        }).catch((error) => {
            if (error.response.status != 422)
                showMessages({ title: `Error: ${error.response.statusText}`, info: `${error.response.data.message}`, kind: "warning", extrainfo: `${error.response.data.exception}` });
            else
                showErrors(error.response.data.errors);
        })
}

submitUpdate = (values) => {
    url = `${model}/update`;
    axios.post(url, values)
        .then((response) => {
            showMessages({ title: 'Registro Actualizado', info: "Se ha Actualizado correctamente el Registro", kind: "success" });
        }).catch((error) => {
            if (error.response.status != 422)
                showMessages({ title: `Error: ${error.response.statusText}`, info: `${error.response.data.message}`, kind: "warning", extrainfo: `${error.response.data.exception}` });
            else
                showErrors(error.response.data.errors);
        })
}

submitDestroy = (values) => {
    url = `${model}/destroy`;
    axios.post(url, values)
        .then((response) => {
            showMessages({ title: 'Registro Eliminado', info: "Se ha Eliminado correctamente el Registro", kind: "success" });
        }).catch((error) => {
            showMessages({ title: `Error: ${error.response.statusText}`, info: `${error.response.data.message}`, kind: "warning", extrainfo: `${error.response.data.exception}` });
        });
}


submitActivate = (values) => {
    url = `${model}/activate`;
    axios.post(url, values)
        .then((response) => {
            showMessages({ title: 'Registro Activado', info: "Se ha reactivado correctamente el Registro", kind: "success" });
        }).catch((error) => {
            showMessages({ title: `Error: ${error.response.statusText}`, info: `${error.response.data.message}`, kind: "warning", extrainfo: `${error.response.data.exception}` });
        })
}

showErrors = (errors) => {
    for (const error in errors) {
        document.getElementById(`${error}`).classList.add('is-invalid');
        document.getElementById(`${error}`).setCustomValidity('invalid');
        document.getElementById(`errors-${error}`).innerText = errors[error];
    }
}

showMessages = (message) => {
    url = `${window.location.origin}/admin/message`
    axios.post(url, message, {
        responseType: 'text'
    }).then((response) => {
        document.getElementById('render-section').innerHTML = response.data;
    }).catch((error) => {
        showMessages({ title: `Error: ${error.response.statusText}`, info: `${error.response.data.message}`, kind: "warning", extrainfo: `${error.response.data.exception}` });
    }).finally(() => {
        setTimeout(() => {
            window.location.replace(`${model}`);
        }, 2500)
    });
}

cleanErrors = () => {

    const fields = ['select', 'input', 'textarea']

    const cleanField = (field) => {
        field.classList.remove('is-invalid');
        field.setCustomValidity('');
    }

    fields.map((field) => {
        document.querySelectorAll(field).forEach((element) => {
            cleanField(element);
        })
    });
}
