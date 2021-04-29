<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCurso extends Model
{
    use HasFactory;

    protected $table = 'tipocurso';

    protected $primaryKey = 'idtipocurso';

    public $incrementing = false;

    protected $fillable = [ 'idtipocurso', 'tipocurso'];
}
