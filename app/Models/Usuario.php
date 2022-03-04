<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $primaryKey = 'idUsuario';
    protected $fillable = [
        'nombreUsuario',
        'apellidoUsuario',
        'correoUsuario',
        'contrasenaUsuario',
        'estadoUsuario',
        'codigoUsuario',
       ];
    use HasFactory;
}
