<?php
    require_once('services/CrudServices.php');

    $crudService = new CrudService();
    $crudService->setTable('genders');

    $array = $crudService->save(array("gender"=>"otro genero", "abrev"=>"og"));
    echo json_encode($array);

    $crudService->setQuery('SELECT * FROM GENDERS');
    $data = $crudService->getByQuery();
    echo json_encode($data);

