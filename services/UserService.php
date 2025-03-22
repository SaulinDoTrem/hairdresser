<?php

    namespace app\services;
    use app\exceptions\ValidateServiceException;
    use app\models\User;

    class UserService {
        const MAX_LENGTH_NAME = 255;
        const MIN_LENGTH_NAME = 3;
        const MIN_LENGTH_PASSWORD = 8;
        const MAX_LENGTH_NICKNAME = 255;
        const MIN_LENGTH_NICKNAME = 8;


        public function createUser(array $data): User {
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

            $this->verifyValidationErrors($errors);

            return new User(
                0,
                $data['name'],
                $data['nickname'],
                $data['password']
            );
        }

        public function validate(User $user):void {
            $errors = [];
            $nameLength = mb_strlen($user->getName());
            if (
                empty($user->getName()) ||
                $nameLength > self::MAX_LENGTH_NAME ||
                $nameLength < self::MIN_LENGTH_NAME
            ) {
                $errors['name'] = 'User names can\'t be empty, have less than '. self::MIN_LENGTH_NAME .' characters or more than '. self::MAX_LENGTH_NAME .' characters';
            }

            $nicknameLength = mb_strlen($user->getNickname());
            //TODO verificar se esse nickname é único
            if (
                empty($user->getNickname()) ||
                $nicknameLength > self::MAX_LENGTH_NICKNAME ||
                $nicknameLength < self::MIN_LENGTH_NICKNAME
            ) {
                $errors['nickname'] = 'User nicknames can\'t be empty, have less than ' . self::MIN_LENGTH_NICKNAME . 'characters or more than '. self::MAX_LENGTH_NICKNAME .' characters';
            }

            if (
                empty($user->getPassword()) ||
                mb_strlen($user->getPassword()) < self::MIN_LENGTH_PASSWORD
            ) {
                $errors['password'] = 'Password can\'t have less than 8 characters';
            }

            $this->verifyValidationErrors($errors);
        }

        private function verifyValidationErrors(array $errors):void {
            if (count($errors) > 0) {
                throw new ValidateServiceException(implode(' ', $errors));
            }
        }
    }