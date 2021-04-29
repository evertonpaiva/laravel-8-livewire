<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $primaryKey = 'iddepto';

    public $incrementing = false;

    protected $fillable = [ 'iddepto', 'depto', 'nome'];
}
