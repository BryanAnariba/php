<?php
    header("Content-Type: aplication/json");
    require_once("../model/conexion-db.php");

    // 1 - mostrar los tipos de cargos en el select de selecciona cargo

    $cargosList = "SELECT ID_CARGO , CARGO FROM TBL_CARGOS";
    $stmt = mysqli_prepare($conexion , $cargosList);

    $exito = mysqli_stmt_execute($stmt);

    if ($exito) {
        $exito = mysqli_stmt_bind_result($stmt , $id , $cargo);
        while ($fila = mysqli_stmt_fetch($stmt)) {
            $toJson[] = array(
                "id" => $id ,
                "cargo" => $cargo
            );
        }

        $jsonToString = json_encode($toJson);
        echo $jsonToString;
    }

    mysqli_close($conexion);
?>