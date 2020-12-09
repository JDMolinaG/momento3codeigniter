<?php namespace App\Models;

use CodeIgniter\Model;

class ModeloRegistro extends Model
{

    protected $table = 'animales';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nombre', 'edad','tipoanimal','descripcion','comida','foto'];

}