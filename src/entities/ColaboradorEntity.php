<?php
namespace admin\foro\Entities;

class ColaboradorEntity {
    private $dni;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $nacionalidad;
    private $emailPersonal;
    private $emailAcademico;
    private $idPSC;

    public function __construct(){}   

    // Setters
    public function setDni($dni) { $this->dni = $dni; return $this; }
    public function setNombre($nombre) { $this->nombre = $nombre; return $this; }
    public function setApellido1($apellido1) { $this->apellido1 = $apellido1; return $this; }
    public function setApellido2($apellido2) { $this->apellido2 = $apellido2; return $this; }
    public function setNacionalidad($nacionalidad) { $this->nacionalidad = $nacionalidad; return $this; }
    public function setEmailPersonal($emailPersonal) { $this->emailPersonal = $emailPersonal; return $this; }
    public function setEmailAcademico($emailAcademico) { $this->emailAcademico = $emailAcademico; return $this; }
    public function setIdPSC($idPSC) { $this->idPSC = $idPSC; return $this; }

    // Getters
    public function getDni() { return $this->dni; }
    public function getNombre() { return $this->nombre; }
    public function getApellido1() { return $this->apellido1; }
    public function getApellido2() { return $this->apellido2; }
    public function getNacionalidad() { return $this->nacionalidad; }
    public function getEmailPersonal() { return $this->emailPersonal; }
    public function getEmailAcademico() { return $this->emailAcademico; }
    public function getIdPSC() { return $this->idPSC; }
}
