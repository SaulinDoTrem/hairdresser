<?php

    namespace app\models;

    /**
     * @inheritDoc
     */
    class UserWithPassword extends User {
        /**
         * @Column
         */
        private string $password;

        /**
         * @Column
         */
        private string $salt;

        public function __construct(
            int $id = 0,
            string $name = '',
            string $nickname = '',
            string $password = '',
            string $salt = ''
        ) {
            parent::__construct($id, $name, $nickname);
            $this->password = $password;
            $this->salt = $salt;
        }

        public function setPassword($password): void {
           $this->password = $password;
        }

        public function getPassword(): string {
            return $this->password;
        }

        public function toUser():User {
            return new User(
                $this->getId(),
                $this->getName(),
                $this->getNickname()
            );
        }

        public function getSalt(): string {
            return $this->salt;
        }

        public function setSalt($salt): void{
            $this->salt = $salt;
        }
    }