<?php

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    // Nombre de la tabla en base de datos
    protected $table = 'professors';

    // Desactivamos los timestamps (created_at, updated_at) ya que no los definimos en database.sql
    public $timestamps = false;

    // Propiedades que se pueden llenar de forma masiva (mass assignment)
    // Se colocan en minúsculas porque PostgreSQL convierte los nombres de las columnas a minúsculas por defecto
    protected $fillable = [
        'fullname',
        'age',
        'email',
        'phone',
        'salary',
        'department',
        'hiredate',
        'officelocation',
    ];
}