<?php
	namespace admin\foro\Helpers;

	class Authentication {

        public static function isUserLogged(): bool {
            return isset($_SESSION['user']);
        }
    
        // Verifica si el usuario tiene un rol específico
        public static function hasRole(string $role): bool {
            // Verifica que el usuario esté logueado
            if (!self::isUserLogged()) {
                return false;
            }
    
            // Obtiene el rol del usuario desde la sesión
            $userEntity = $_SESSION['user'];
            $userRole = $userEntity->getNombreRol();
    
            // Compara el rol del usuario con el rol esperado
            return $userRole === $role;
        }
    
        // Método para verificar si el usuario es un Administrador
        public static function isAdmin(): bool {
            return self::hasRole("administrador");
        }
        // Método para verificar si el usuario es un colaborador
        public static function isCollaborator(): bool {
            return self::hasRole("coordinador");
        }
    
        // Método para verificar si el usuario es una secretaria
        public static function isSecretary(): bool {
            return self::hasRole("secretaria");
        }
    }
    