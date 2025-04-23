<?php

    namespace app\daos;
    use app\models\User;
    use app\models\UserWithPassword;

    class UserDao extends Dao {
        public function existsByNickname(User $user):bool {
            return $this->existsBy('nickname', $user, $user->getNickname());
        }

        public function getUserByNickname(string $nickname):UserWithPassword|null {
            return $this->getByColumn('nickname', $nickname, UserWithPassword::class);
        }
    }