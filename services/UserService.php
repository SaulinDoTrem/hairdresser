<?php

    namespace app\services;
    use app\core\Settings;
    use app\daos\UserDao;
    use app\models\User;
    use app\models\UserWithPassword;

    class UserService extends Service{
        const MAX_LENGTH_NAME = 255;
        const MIN_LENGTH_NAME = 3;
        const MIN_LENGTH_PASSWORD = 8;
        const MAX_LENGTH_NICKNAME = 255;
        const MIN_LENGTH_NICKNAME = 8;

        public function createUser(array $data): User {
            return new User(
                0,
                $data['name'],
                $data['nickname']
            );
        }

        public function createUserWithPassword(array $data): UserWithPassword {
            return new UserWithPassword(
                0,
                $data['name'],
                $data['nickname'],
                $data['password']
            );
        }

        public function validateUser(User $user, UserDao $dao):array {
            $errors = [];
            $nameLength = mb_strlen($user->getName());
            if (
                empty($user->getName()) ||
                $nameLength > self::MAX_LENGTH_NAME ||
                $nameLength < self::MIN_LENGTH_NAME
            ) {
                $errors['name'] = 'User names can\'t be empty, have less than '. self::MIN_LENGTH_NAME .' characters or more than '. self::MAX_LENGTH_NAME .' characters.';
            }

            $nicknameLength = mb_strlen($user->getNickname());
            if (
                empty($user->getNickname()) ||
                $nicknameLength > self::MAX_LENGTH_NICKNAME ||
                $nicknameLength < self::MIN_LENGTH_NICKNAME
            ) {
                $errors['nickname'] = 'User nicknames can\'t be empty, have less than ' . self::MIN_LENGTH_NICKNAME . 'characters or more than '. self::MAX_LENGTH_NICKNAME .' characters.';
            } elseif ($dao->existsByNickname($user)) {
                $errors['nickname'] = 'This nickname is already been used, try another one.';
            }

            return $errors;
        }

        public function validateUserWithPassword(UserWithPassword $user, UserDao $dao):array {
            $errors = $this->validateUser($user, $dao);

            if (
                empty($user->getPassword()) ||
                mb_strlen($user->getPassword()) < self::MIN_LENGTH_PASSWORD
            ) {
                $errors['password'] = 'Password can\'t have less than 8 characters.';
            }

            return $errors;
        }

        private function genereteRandomSalt():string {
            return bin2hex(random_bytes(32));
        }

        public function encryptPassword(UserWithPassword $user):void {
            $salt = $this->genereteRandomSalt();
            $pepper = Settings::$USER_PASSWORD_PEPPER;
            $password = $salt.$user->getPassword().$pepper;
            $password = password_hash($password, Settings::$USER_PASSWORD_ENCRYPT_ALGO);
            $user->setPassword($password);
            $user->setSalt($salt);
        }

        public function toDataObject(object $object):array {
            if (get_class($object) === UserWithPassword::class) {
                $object = $object->toUser();
            }
            return parent::toDataObject($object);
        }
    }