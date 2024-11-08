<?php
namespace admin\foro\Models;

class ComunidadesModel extends Model {

    private $conexion;
    private $comunidades;

    public function __construct()
    {
        parent::__construct();
        $this->tabla="comunidades";
    }
    public function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
