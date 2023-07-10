<?php
    require __DIR__.'/../../vendor/autoload.php';

    use Hairdresser\Model\Database;
    use Hairdresser\Model\City;
    use Hairdresser\Model\FederativeUnit;

    $city = new City();

    $federativeUnit = new FederativeUnit();
    $federativeUnit->fromMap([
        "id"=> 1,
        "name"=>"Rio de Janeiro",
        "acronym"=>"RJ"
    ]);

    $city->fromMap([
        "id"=> 1,
        "federative_unit"=> $federativeUnit->toMap(),
        "name"=> "Nova Friburgo"
    ]);

    $array = $city->toMap();

    echo "You live in {$array["name"]}, {$array["federative_unit"]["name"]} ({$array["federative_unit"]["acronym"]}).";
?>