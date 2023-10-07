<?php
    namespace app\controllers;
    use app\core\Request;
    use app\models\BeautySalon;
    use app\models\FederativeUnit;
    use app\models\Neighborhood;
    use app\models\Person;

    class testaController extends AbstractController{
        const PATH = "/testa";
        public function __construct() {
            $model = new FederativeUnit();
            $this->setModel($model);
        }


    }
?>