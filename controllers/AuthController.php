<?php
    namespace app\controllers;
    use app\models\Auth;
    use app\core\Request;

    class AuthController{

        /**
         * @path["/api/v1/auth"]
         * @method["POST"]
         */
        public function login(Request $request):array {
            //TODO - Fazer autenticação
            return [
                'dale' => 'porra'
            ];
        }
    }
