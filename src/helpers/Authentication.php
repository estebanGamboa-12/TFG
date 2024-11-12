<?php
	namespace admin\foro\Helpers;

	class Authentication {

        public static function isUserLogged(): bool {
            return isset($_SESSION['user']);
        }
    }
    