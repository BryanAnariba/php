<?php
    session_start();
    if (!isset($_SESSION['ID_USUARIO']) && !isset($_SESSION["NOMBRE_USUARIO"]) && !isset($_SESSION["EMAIL_USUARIO"]) && !isset($_SESSION['token'])) {
        header("Location: 401.html");
    }
    if (!isset($_COOKIE['token'])) {
        header("Location: 401.html");
    }
    if ($_SESSION['token'] != $_COOKIE['token']) {
        header("Location: 401.html");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Principal</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Bienvenido(@)</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"> <?php echo $_SESSION["NOMBRE_USUARIO"] ?><span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <button type="button" class="btn btn-outline-success mr-2 my-2 my-sm-0" data-toggle="modal" data-target="#modalAgregaTarea">Ver tabla usuarios</button>
                    <a class="btn btn-outline-success my-2 my-sm-0" href="../backend/controllers/log-out.php">Cerrar Sesion</a>
                </form>
            </div>
        </div>
    </nav>

    <!--Zona del modal-->
    <!-- Modal -->
    <div class="modal fade" id="modalAgregaTarea" tabindex="-1" role="dialog" aria-labelledby="modalAgregaTareaLabel"
        aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregaTareaLabel">Agrege su tarea: <?php echo $_SESSION["EMAIL_USUARIO"] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <table id="myTableDataTable" class="display">
                        <thead>
                            <tr>
                                <th>Nombre Usuario</th>
                                <th>Apellido Usuario</th>
                                <th>ID Cargo Usuario</th>
                                <th>Email Usuario</th>
                                <th>Eliminar Usuario</th>
                            </tr>
                        </thead>
                        <tbody id="userTable">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar Modal</button>
                    <button type="button" class="btn btn-success">Guardar Tarea</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS, Popper.js, and jQuery -->
    <script src="./js/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="./js/axios.min.js" type="text/javascript"></script>
    <script src="./js/users.controller.js" type="text/javascript"></script>
    <script src="./js/paginacion.js" type="text/javascript"></script>
</body>

</html>