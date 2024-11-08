<?php
	namespace admin\foro\Entities;

	class UserEntity{
        private $usuario;
        private $password;
        private $idRol;
        private $estado;
        private  $nombreRol;

        public function __construct(){}   
        public function setUsuario($usuario){$this->usuario = $usuario; return $this;}
        public function setPassword($password){$this->password = $password; return $this;}
        public function setIdRol($idRol){$this->idRol = $idRol; return $this;}
        public function setEstado($estado){$this->estado = $estado; return $this;}
        public function setNombreRol($nombreRol) {$this->nombreRol = $nombreRol; return $this; }
        
        public function getUsuario(){ return $this->usuario;}
        public function getPassword(){ return $this->password;}
        public function getIdRol(){ return $this->idRol;}
        public function getEstado(){ return $this->estado;}
        public function getNombreRol() {return $this->nombreRol;}
    }