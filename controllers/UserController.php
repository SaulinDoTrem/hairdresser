<?php
    namespace app\controllers;
    use app\core\Request;
    use app\core\Response;
    use app\services\UserService;
    use app\daos\Dao;
    use app\enums\HttpStatus;

    /**
     * @route["/api/v1/user"]
     */
    class UserController{
        private Dao $dao;
        private UserService $service;

        public function __construct(UserService $service, Dao $dao) {
            $this->service = $service;
            $this->dao = $dao;
        }

        /**
         * @path["/"]
         * @method["POST"]
         */
        public function create(Request $request, Response $response):void {
            $data = $request->getData();
            $user = $this->service->createUser($data);
            $this->service->validate($user);
            $this->dao->insert($user);
            $response->setStatusCode(HttpStatus::CREATED);
            $response->setData($this->service->toResponseData($user));
        }
    }
