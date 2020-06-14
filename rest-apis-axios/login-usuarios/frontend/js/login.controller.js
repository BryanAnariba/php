// Zona de variables
var cargos = [];

// Limpiando casillas
function limpiaCasillasLogin () {
    document.querySelector('#emailUsuario').value = '';
    document.querySelector('#passwordUsuario').value = '';
}
function limpiaCasillasRegistro () {
    document.querySelector('#nombreUsuario').value = '';
    document.querySelector('#apellidoUsuario').value = '';
    document.querySelector('#fechaNacimiento').value = '';
    document.querySelector('#llenaTabla').value = '';
    document.querySelector('#email').value = '';
    document.querySelector('#password').value = '';
}

// Zona de mostrar contenedores
function muestraLoginUser () {
    document.querySelector('#login-container').style.display = 'block';
    document.querySelector('#signup-container').style.display = 'none';
    limpiaCasillasRegistro();
    limpiaCasillasLogin();
}

function muestraSignUp () {
    document.querySelector('#login-container').style.display = 'none';
    document.querySelector('#signup-container').style.display = 'block';
    limpiaCasillasRegistro();
    limpiaCasillasLogin();
}

function dameCargos () {
    axios({
        method: 'GET' ,
        url: '../../login-usuarios/backend/api/view-roles-router.php',
        responseType: 'json'
    })
    .then((success) => {
        cargos = success.data;
        console.log(cargos);
        for (let i=0; i<cargos.length; i++) {
            document.querySelector('#llenaTabla').innerHTML += 
            `<option value="${ cargos[i].id }">${ cargos[i].cargo }</option>`;
        }
    })
    .catch((error) => {
        console.error(error);
    });
}
dameCargos();

//-----------------------------------------------------------> Consumo API Axios

// Logueo de un usuario
function iniciarSesion () {
    let parametros = {
        emailUsuario: document.querySelector('#emailUsuario').value ,
        passwordUsuario: document.querySelector('#passwordUsuario').value 
    };
    axios({
        method: 'POST' ,
        url: '../../login-usuarios/backend/api/login-router.php' ,
        data: parametros ,
        responseType: 'json'
    })
    .then((success) => {
        if (success.data.statusCode == 1) {
            window.location.href='landing-page.php';
        }
        if (success.data.statusCode == 2 || success.data.statusCode == 3) {   
            console.log(success.data);
        }
        limpiaCasillasLogin ();
    })
    .catch((error) => {
        console.error(error);
    });
}

function registrarUsuario () {
    let parametros = {
        nombreUsuario: document.querySelector('#nombreUsuario').value , 
        apellidoUsuario: document.querySelector('#apellidoUsuario').value , 
        fechaNacimiento: document.querySelector('#fechaNacimiento').value , 
        email: document.querySelector('#email').value , 
        password: document.querySelector('#password').value , 
        cargoUsuario: document.querySelector('#llenaTabla').value
    };
    axios({
        method: 'POST' ,
        url: '../../login-usuarios/backend/api/login-router.php' ,
        data: parametros ,
        responseType: 'json'
    })
    .then((success) => {
        console.log(success.data);
        limpiaCasillasRegistro ();
    })
    .catch((error) => {
        console.error(error);
    });
}