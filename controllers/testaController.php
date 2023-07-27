<?php
    namespace app\controllers;
    use app\core\Request;
    use app\models\BeautySalon;
    use app\models\FederativeUnit;

    class testaController extends AbstractController{
        const PATH = "/testa";
        public function __construct() {
            $model = new BeautySalon();
            $this->setModel($model);
        }


    }
?>