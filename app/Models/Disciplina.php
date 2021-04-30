<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $primaryKey = 'disciplina';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [ 'disciplina', 'nome', 'iddepto'];

    /**
     * Recupera o Departamento da Disciplina
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'iddepto', 'iddepto');
    }
}
