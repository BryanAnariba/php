var usuarios = [];
var cargos = [];
var usuario = {};
var idUser = null;

function listarCargos () {
    axios({
        method: 'GET' ,
        url: '../../rest-api-usuarios/backend/api/listar-cargos.php' ,
        responseType: 'json' 
    })
    .then((success) => {
        cargos = success.data;
        console.log(cargos);
        for (let i = 0; i< cargos.length ; i++) {
            document.querySelector('#llenaTabla').innerHTML +=
            `
                <option value=${ cargos[i].id } >${ cargos[i].cargo }</option>
            `
        }
    })
    .catch((error) => {
        console.error(error);
    });
}
listarCargos ();

function obtenerUsuarios () {
    axios({
        method: 'GET' ,
        url: '../../rest-api-usuarios/backend/api/router-usuarios.php' ,
        responseType: 'json'
    })
    .then((success) => {
        document.querySelector('#pintar-datos').innerHTML = ``;
        usuarios = success.data;
        console.log(usuarios);
        for (let i = 0; i<usuarios.length; i++) {
            document.querySelector('#pintar-datos').innerHTML +=
            `
                <tr>
                    <td>${ usuarios[i].IdUsuario }</td>
                    <td>${ usuarios[i].nombreUsuario }</td>
                    <td>${ usuarios[i].apellidoUsuario }</td>
                    <td>${ usuarios[i].emailUsuario }</td>
                    <td>${ usuarios[i].cargo }</td>
                    <td><button type="button" class="btn btn-primary" onclick="retornameUsuario(${ usuarios[i].IdUsuario })"><img src="img/lapiz.png"/></button></td>
                    <td><button type="button" class="btn btn-danger" onclick="eliminarUsuario(${ usuarios[i].IdUsuario })"><img src="img/compartimiento.png"/></button></td>
                </tr>
            `;
        }
    })
    .catch((error) => {
        console.error(error);
    });
}
obtenerUsuarios ();

function retornameUsuario (id) {
    console.log({'Identificador Usuario Seleccionado': id});
    idUser = id;
    axios({
        method: 'GET' ,
        url: `../../rest-api-usuarios/backend/api/router-usuarios.php/?id=${ id }` ,
        responseType: 'json'
    })
    .then((success) => {
        usuario = success.data;
        console.log(usuario);
        document.querySelector('#nombreUsuario').value = usuario.nombreUsuario;
        document.querySelector('#apellidoUsuario').value = usuario.apellidoUsuario;
        document.querySelector('#fechaNacimiento').value = usuario.fechaNacimiento;
        document.querySelector('#llenaTabla').value = usuario.IdCargo;
        document.querySelector('#email').value = usuario.emailUsuario;
        document.querySelector('#password').style.display = 'none';
        document.getElementById('btnActualizar').style.display = 'block';
        document.getElementById('btnGuardar').style.display = 'none';
    })
    .catch((error) => {
        console.error(error);
    });
}

function eliminarUsuario (id) {
    console.log({'Identificador Usuario Seleccionado': id});
    axios({
        method: 'DELETE' ,
        url: `../../rest-api-usuarios/backend/api/router-usuarios.php/?id=${ id }`,
        responseType: 'json' 
    })
    .then((success) => {
        console.log(success.data);
        obtenerUsuarios();
        limpiaTabla();
    })
    .catch((error) => {
        console.error(error);
    })

}

function actualizarUsuario () {
    usuario = {
        nombreUsuario: document.querySelector('#nombreUsuario').value ,
        apellidoUsuario: document.querySelector('#apellidoUsuario').value ,
        fechaNacimiento: document.querySelector('#fechaNacimiento').value ,
        cargo: document.querySelector('#llenaTabla').value ,
        email: document.querySelector('#email').value
    };
    axios({
        method: 'PUT' ,
        url: `../../rest-api-usuarios/backend/api/router-usuarios.php/?id=${ idUser }` ,
        responseType: 'json' ,
        data: usuario
    })
    .then((success) => {
        console.log(success.data);
        obtenerUsuarios ();
        limpiaTabla(); 
        document.querySelector('#btnActualizar').style.display = 'none';
        document.querySelector('#btnGuardar').style.display = 'block';
        document.querySelector('#password').style.display = 'block';
    })
    .catch((error) => {
        console.erro(error);
    });
}

function guardarUsuario () {  
    document.querySelector('#password').style.display = 'block';
    usuario = {
        nombreUsuario: document.querySelector('#nombreUsuario').value ,
        apellidoUsuario: document.querySelector('#apellidoUsuario').value ,
        fechaNacimiento: document.querySelector('#fechaNacimiento').value ,
        cargo: document.querySelector('#llenaTabla').value ,
        email: document.querySelector('#email').value ,
        password: document.querySelector('#password').value
    };
    axios({
        method: 'POST' ,
        url: '../../rest-api-usuarios/backend/api/router-usuarios.php' ,
        responseType: 'json' ,
        data: usuario
    })
    .then((success) => {
        let response = {};
        response =success.data;
        let mensaje = response.mensaje;
        document.getElementById('response').innerHTML = mensaje;

        $('.toast').toast('show');
        console.log(success.data);
        obtenerUsuarios ();
        limpiaTabla();
    })
    .catch((error) => {
        console.error(error);
    });
}

function limpiaTabla () {
    document.querySelector('#nombreUsuario').value = '';
    document.querySelector('#apellidoUsuario').value = '';
    document.querySelector('#fechaNacimiento').value = '';
    document.querySelector('#llenaTabla').value = '';
    document.querySelector('#email').value = '';
    document.querySelector('#password').value = '';
}