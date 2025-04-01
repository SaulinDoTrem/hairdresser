<?php

    namespace app\models;

    /**
     * @inheritDoc
     */
    class UserWithPassword extends User {
        /**
         * @column
         */
        private string $password;

        public function __construct(
            int $id = 0,
            string $name = '',
            string $nickname = '',
            string $password = ''
        ) {
            parent::__construct($id, $name, $nickname);
            $this->password = $password;
        }

        public function setPassword($password) {
           $this->password = $password;
        }

        public function getPassword() {
            return $this->password;
        }

        public function toUser():User {
            return new User(
                $this->getId(),
                $this->getName(),
                $this->getNickname()
            );
        }
    }