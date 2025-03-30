<?php

    namespace app\models;

    /**
     * @table["user"]
     */
    class User {
        /**
         * @column
         * @primary
         */
        private int $id;
        /**
         * @column
         */
        private string $name;
        /**
         * @column
         */
        private string $nickname;
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
            $this->id = $id;
            $this->name = $name;
            $this->nickname = $nickname;
            $this->password = $password;
        }

        public function setId($id) {
           $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setName($name) {
           $this->name = $name;
        }

        public function getName() {
            return $this->name;
        }

        public function setNickname($nickname) {
           $this->nickname = $nickname;
        }

        public function getNickname() {
            return $this->nickname;
        }

        public function setPassword($password) {
           $this->password = $password;
        }

        public function getPassword() {
            return $this->password;
        }
    }