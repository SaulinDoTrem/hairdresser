<?php

    namespace app\daos;
    use app\models\User;

    class UserDao extends Dao {
        public function existsByNickname(User $user) {
            return $this->existsBy('nickname', $user, $user->getNickname());
        }
    }