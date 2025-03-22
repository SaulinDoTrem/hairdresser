<?php
    namespace app\controllers;
    use app\core\Request;
    use app\core\Response;
    use app\services\UserService;
    use app\daos\Dao;
use app\enums\HttpStatus;

    class UserController{
        private Dao $dao;
        private UserService $service;

        public function __construct(UserService $service, Dao $dao) {
            $this->service = $service;
            $this->dao = $dao;
        }

        /**
         * @path["/api/v1/user"]
         * @method["POST"]
         */
        public function create(Request $request, Response $response):Response {
            $data = $request->getData();
            $user = $this->service->createUser($data);
            $this->service->validate($user);
            $this->dao->insert($user);
            $response->setStatusCode(HttpStatus::CREATED);
            return $response;
        }
    }
