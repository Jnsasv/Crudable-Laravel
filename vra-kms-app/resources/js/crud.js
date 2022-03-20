// El funcionamiento de Crud depende de el uso de Axios implementado en app.js

// const { default: axios } = require("axios")

createRecord = ()=>{
    axios.get('role/create',{
        responseType : 'text'
    })
    .then(function (response) {
        document.getElementById('render-section').innerHTML = response.data;
    });
}

editRecord = (id)=>{
    axios.get(`role/edit/${id}`,{
        responseType : 'text'
    })
    .then(function (response) {
        document.getElementById('render-section').innerHTML = response.data;
    });
}
