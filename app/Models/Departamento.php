<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $primaryKey = 'iddepto';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [ 'iddepto', 'depto', 'nome'];

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class, 'iddepto', 'iddepto');
    }
}
