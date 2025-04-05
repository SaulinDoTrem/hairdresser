<?php
    namespace app\controllers;
    use app\core\Request;
    use app\core\Response;
    use app\daos\UserDao;
    use app\exceptions\ValidateClientDataException;
    use app\models\User;
    use app\services\UserService;
    use app\enums\HttpStatus;

    /**
     * @route["/api/v1/user"]
     */
    class UserController{
        private UserDao $dao;
        private UserService $service;

        public function __construct(UserService $service, UserDao $dao) {
            $this->service = $service;
            $this->dao = $dao;
        }

        /**
         * @path["/"]
         * @method["POST"]
         */
        public function create(Request $request, Response $response):void {
            $data = $request->getData();
            $this->throwValidationErrorsIfExists(
                $this->validateRequestData($data)
            );

            $user = $this->service->createUserWithPassword($data);
            $this->throwValidationErrorsIfExists(
                $this->service->validateUserWithPassword($user, $this->dao)
            );

            $this->dao->insert($user);
            $response->setStatusCode(HttpStatus::CREATED);
            $response->setData($this->service->toDataObject($user));
        }

        /**
         * @path["/"]
         * @method["GET"]
         */
        public function getAll(Request $request, Response $response):void {
            $users = [];
            foreach ($this->dao->getAll(User::class) as $user) {
                $users[] = $this->service->toDataObject($user);
            }
            $response->setData($users);
            $response->setStatusCode(HttpStatus::OK);
        }

        private function validateRequestData(array $data):array {
            $errors = [];

            if (empty($data['name'])) {
                $errors['name'] = 'Name can\'t be empty.';
            }

            if (empty($data['nickname'])) {
                $errors['nickname'] = 'Nickname can\'t be empty.';
            }

            if (empty($data['password'])) {
                $errors['password'] = 'Password can\'t be empty.';
            }

            return $errors;
        }

        private function throwValidationErrorsIfExists(array $errors):void {
            if (count($errors) > 0) {
                throw new ValidateClientDataException(implode(' ', $errors));
            }
        }
    }
