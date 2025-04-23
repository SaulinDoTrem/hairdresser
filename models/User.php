<?php

    namespace app\models;

    /**
     * @Table["user"]
     */
    class User {
        /**
         * @Column
         * @Primary
         */
        private int $id;
        /**
         * @Column
         */
        private string $name;
        /**
         * @Column
         */
        private string $nickname;
        public function __construct(
            int $id = 0,
            string $name = '',
            string $nickname = ''
        ) {
            $this->id = $id;
            $this->name = $name;
            $this->nickname = $nickname;
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
    }