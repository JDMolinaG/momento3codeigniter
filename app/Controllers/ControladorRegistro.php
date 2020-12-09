<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ControladorRegistro extends ResourceController
{
    protected $modelName = 'App\Models\ModeloRegistro';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function insertar()
    {
        $nombre = $this->request->getPost("nombre");
        $edad = $this->request->getPost("edad");
        $tipoanimal = $this->request->getPost("tipoanimal");
        $descripcion = $this->request->getPost("descripcion");
        $comida = $this->request->getPost("comida");
        $foto = $this->request->getPost("foto");

        $datos = array(
            "nombre" => $nombre,
            "edad" => $edad,
            "tipoanimal" => $tipoanimal,
            "descripcion" => $descripcion,
            "comida" => $comida,
            "foto" => $foto
        );

        if ($this->validate('animalesPOST')) {
            $id = $this->model->insert($datos);
            return $this->respond($this->model->find($id));
        } else {
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors());
        }
    }

    public function eliminar($id)
    {
        $consulta = $this->model->where('id', $id)->delete();

        $filasAfectadas = $consulta->connID->affected_rows;
        if ($filasAfectadas == 1) {
            $mensaje = array("mensaje" => "Registro eliminado con exito");
            return $this->respond(json_encode($mensaje));
        } else {
            $mensaje = array("mensaje" => "El id no se encuentra");
            return $this->respond(json_encode($mensaje), 400);
        }
    }

    public function editar($id)
    {
        $datosAEditar = $this->request->getRawInput();

        $nombre = $datosAEditar["nombre"];
        $edad = $datosAEditar["edad"];

        $datos = array(
            "nombre" => $nombre,
            "edad" => $edad,

        );

        if ($this->validate('animalesPUT')) {
            $this->model->update($id, $datos);
            return $this->respond($this->model->find($id));
        } else {
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors());
        }
    }

    public function buscar($id)
    {
        $cons=$this->model->find($id);
        if($cons){
            return $this->respond($this->model->find($id));
        }else{
            $mensaje = array("mensaje" => "El id no se encuentra");
            return $this->respond(json_encode($mensaje), 400);
        }
    }
}
