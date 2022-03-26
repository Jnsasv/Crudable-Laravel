// El funcionamiento de Crud depende de el uso de Axios implementado en app.js

// const { default: axios } = require("axios")

createRecord = ()=>{
    axios.get(`${model}/create`,{
        responseType : 'text'
    })
    .then(function (response) {
        document.getElementById('render-section').innerHTML = response.data;
        document.getElementById('crud-form').addEventListener('submit',handleSubmit);
    });
}

editRecord = (id)=>{
    axios.get(`${model}/edit/${id}`,{
        responseType : 'text'
    })
    .then(function (response) {
        document.getElementById('render-section').innerHTML = response.data;
        document.getElementById('crud-form').addEventListener('submit',handleSubmit);
    });
}

handleSubmit =(event) =>{
    event.preventDefault();

    cleanErrors();
    const data = new FormData(event.target);
    const values = Object.fromEntries(data.entries());
    console.log(values);

    url = values.id == 0 ? `${model}/store`:`${model}/update`;
    axios.post(url,values)
    .then((response)=>{
        console.log(response,1);
    }).catch((error)=>{
        if(error.response.status !=422)
            window.alert(error);
        else
            showErrors(error.response.data.errors);
    })
}

showErrors = (errors) =>{
    for (const error in errors) {
        document.getElementById(`${error}`).classList.add('is-invalid');
        document.getElementById(`${error}`).setCustomValidity('invalid');
        document.getElementById(`errors-${error}`).innerText = errors[error];
    }
    // document.getElementById('crud-form').classList.add('was-validated');
}

cleanErrors = ()=>{

    const fields = ['select','input','textarea']

    const cleanField = (field)=>{
        field.classList.remove('is-invalid');
        field.setCustomValidity('');
    }


    fields.map((field)=>{
        document.querySelectorAll(field).forEach((element)=>{
            cleanField(element);
        })
    });


}
