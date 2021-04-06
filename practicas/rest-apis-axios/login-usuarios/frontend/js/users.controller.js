var dataUser = [];

function getUsers () {
    axios({
        method: 'GET' ,
        url: '../../login-usuarios/backend/api/user-router.php',
        responseType: 'json'
    })
    .then((success) => {
        dataUser = success.data;
        console.log(dataUser);
        llenarTable(dataUser);
    })
    .catch((error) => {
        console.error(error);
    });
}

getUsers ();

function llenarTable () {
    document.getElementById('userTable').innerHTML = '';
        for (let i=0;i<dataUser.length;i++) {
            if (dataUser[i].codigoUser == 0) {
                document.querySelector('#userTable').innerHTML += `
                    <tr>
                        <td>${ dataUser[i].mensaje }</td>
                    </tr>`;
            } else {
                document.querySelector('#userTable').innerHTML += `
                    <tr>
                        <td>${ dataUser[i].idUsuario }</td>
                        <td>${ dataUser[i].nombreUsuario }</td>
                        <td>${ dataUser[i].apellidoUsuario }</td>
                        <td>${ dataUser[i].emailUsuario }</td>
                        <td><input type="button" onclick="eliminarUsuario (${ dataUser[i].idUsuario })" class="btn btn-outline-danger" value="Eliminar Usuario"/></td>
                    </tr>
                `;
            }
        }
        
            
        $('#myTableDataTable').DataTable();
}
