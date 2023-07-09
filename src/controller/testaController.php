<?php
    require __DIR__.'/../../vendor/autoload.php';

    use Hairdresser\Model\Database;
    use Hairdresser\Model\City;

    $city = new City();

    $array = $city->toMap();

    var_dump($array);

    // $database = new Database("cidade");

    // $lastInsertId = $database->insert(["uf_id"=>1, "nome"=> "teste"]);

    // echo "lastInsertId = {$lastInsertId} <br>";

    // echo "affectedRows do update = {$database->update($lastInsertId, ["nome"=> "outro teste"])} <br>";

    // var_dump($database->select(["id","nome","uf_id"], "id = {$lastInsertId}", "nome DESC", "0,1"));

    // echo "<br>affectedRows do delete = {$database->delete($lastInsertId)} <br>";
?>