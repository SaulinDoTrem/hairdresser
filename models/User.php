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

        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getNickname() {
            return $this->nickname;
        }

        public function getPassword() {
            return $this->password;
        }
    }